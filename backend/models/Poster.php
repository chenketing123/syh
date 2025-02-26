<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%poster}}".
 *
 * @property string $id
 * @property string $title
 * @property string $cover
 * @property string $background
 * @property string $head_x
 * @property string $head_y
 * @property string $qr_x
 * @property string $qr_y
 * @property string $nickname_x
 * @property string $nickname_y
 * @property integer $type_x
 * @property integer $type_y
 * @property string $intro_x
 * @property string $intro_y
 * @property string $code_x
 * @property string $code_y
 * @property integer $status
 * @property string $sort
 * @property string $append
 * @property string $updated
 */
class Poster extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%poster}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'cover', 'background', 'head_x', 'head_y', 'qr_x', 'qr_y', 'nickname_x', 'nickname_y', 'type_x', 'type_y', 'intro_x', 'intro_y', 'code_x', 'code_y', 'status'], 'required'],
            [['is_default','head_x', 'head_y', 'qr_x', 'qr_y', 'nickname_x', 'nickname_y', 'type_x', 'type_y', 'intro_x', 'intro_y', 'code_x', 'code_y', 'status', 'sort', 'append', 'updated'], 'integer'],
            [['title', 'cover', 'background','font_color'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '标题',
            'cover' => '封面',
            'background' => '底图',
            'head_x' => '头像X',
            'head_y' => '头像Y',
            'qr_x' => '二维码X',
            'qr_y' => '二维码Y',
            'nickname_x' => '昵称X',
            'nickname_y' => '昵称Y',
            'type_x' => '类型X',
            'type_y' => '类型Y',
            'intro_x' => '简介X',
            'intro_y' => '简介Y',
            'code_x' => '邀请码X',
            'code_y' => '邀请码Y',
            'font_color'=>'字体颜色',
            'is_default'=>'是否默认',
            'status' => '状态',
            'sort' => '排序',
            'append' => '添加时间',
            'updated' => '修改时间',
        ];
    }

    /**
    * @return array
    */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['append', 'updated'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated'],
                ],
            ],
        ];
    }

    //保存后事件
    public function afterSave($insert, $changedAttributes)
    {
        //$changedAttributes  要改变的字段，未改变的值
        //$this->字段名  改变保存的值
        parent::afterSave($insert, $changedAttributes);

        if ($insert) {
            //新增处理

        }else{
            //修改处理
        }
    }

    /**
     * @return string
     * User:五更的猫
     * DateTime:2021/4/27 16:37
     * TODO 生成分享图
     */
    public function GetCover($filename='',$qr_path='',$code='',$head_path='',$nickname='',$type='',$intro=''){

        //\Yii::$app->response->clearOutputBuffers();

        //案例一：将活动背景图片和动态二维码图片合成一张图片
        //底图
        //$dst_path = Yii::getAlias("@attachment/").$this->background;
        $dst_path = Yii::getAlias("@webPath/").$this->background;


        //合成图片
        //imagecopymerge ( resource $dst_im , resource $src_im , int $dst_x , int $dst_y , int $src_x , int $src_y , int $src_w , int $src_h , int $pct )---拷贝并合并图像的一部分
        //将 src_im 图像中坐标从 src_x，src_y 开始，宽度为 src_w，高度为 src_h 的一部分拷贝到 dst_im 图像中坐标为 dst_x 和 dst_y 的位置上。两图像将根据 pct 来决定合并程度，其值范围从 0 到 100。当 pct = 0 时，实际上什么也没做，当为 100 时对于调色板图像本函数和 imagecopy() 完全一样，它对真彩色图像实现了 alpha 透明。

        //创建图片的实例
        $dst = imagecreatefromstring(file_get_contents($dst_path));

        if(!empty($head_path) && !empty($this->head_x) && !empty($this->head_y)) {
            //头像
            list($imgg,$w) = $this->yuan_img($head_path);//yuan_img() 方法在文末会列出
            //裁剪为132*132的
            $imgg = $this->get_new_size($imgg,132,132,$w);//小程序头像其实不用裁剪，小程序头像本身就是132*132的，不过文档好像没更新//$file_name = "4_".time().".png";
            imagecopy($dst, $imgg, $this->head_x, $this->head_y, 0, 0, 132, 132);

            //头像
            //$src = imagecreatefromstring(file_get_contents($head_path));
            //获取水印图片的宽高
            //$src_w = 120;
            //$src_h = 120;
            //list($src_w, $src_h) = getimagesize($head_path);
            //如果水印图片本身带透明色，则使用imagecopy方法
            //imagecopy($dst, $src, 85, 845, 0, 0, $src_w, $src_h);
        }


        if(!empty($qr_path) && !empty($this->qr_x) && !empty($this->qr_y)) {
            //二维码
            $src = imagecreatefromstring(file_get_contents($qr_path));
            //获取水印图片的宽高
            $src_w = 75;
            $src_h = 75;
            list($src_w, $src_h) = getimagesize($qr_path);
            //如果水印图片本身带透明色，则使用imagecopy方法
            imagecopy($dst, $src, $this->qr_x, $this->qr_y, 0, 0, $src_w, $src_h);
        }

        $color = explode(',',$this->font_color);

        $black = imagecolorallocate($dst ,  $color[0] ,  $color[1] ,  $color[2] );//为该图片定义一个颜色
        $font = Yii::getAlias("@attachment/")."fonts/simhei.ttf";//已有的子图路径

        $black2 = imagecolorallocate($dst ,  255 ,  255 ,  255 );//为该图片定义一个颜色

        $black3 = imagecolorallocate($dst ,  226 ,  10 ,  67 );//为该图片定义一个颜色


        if(!empty($nickname) && !empty($this->nickname_x) && !empty($this->nickname_y)) {
            //昵称
            imagettftext($dst, 26, 0, $this->nickname_x, $this->nickname_y, $black, $font, $nickname);//往图片上添加文字
        }

        if(!empty($type) && !empty($this->type_x) && !empty($this->type_y)) {
            //imagefilledrectangle($dst,500,85,600,118,$black3);

            $type_x = $this->type_x-2;
            if(strlen($type)>12){
                $type_x = $type_x-(strlen($type)-12)/3*24/2;
            }
            $type_x = $type_x>300?$type_x:$this->type_x;

            $this->arcRec($dst, $type_x, $this->type_y-25, $type_x+strlen($type)/3*24, $this->type_y+8, 3, $black3);

            //类型
            imagettftext($dst, 18, 0, $type_x+2, $this->type_y, $black2, $font, $type);//往图片上添加文字
        }
        if(!empty($intro) && !empty($this->intro_x) && !empty($this->intro_y)) {
            //介绍
            imagettftext($dst, 18, 0, $this->intro_x, $this->intro_y, $black, $font, $intro);//往图片上添加文字

        }
        if(!empty($code) && !empty($this->code_x) && !empty($this->code_y)) {
            //邀请码
            imagettftext($dst, 70, 0, $this->code_x, $this->code_y, $black, $font, $code);//往图片上添加文字
        }

        //输出图片
        list($src_w, $src_h, $dst_type) = getimagesize($dst_path);
        switch ($dst_type) {
            case 1://GIF
                //header('Content-Type: image/gif');
                @imagegif($dst, $filename);
                //exit();
                break;
            case 2://JPG
                //header('Content-Type: image/jpeg');
                //第三位参数  质量 0-100
                @imagejpeg($dst, $filename,100);
                //var_dump($filename);
                //exit();
                break;
            case 3://PNG
                //header('Content-Type: image/png');
                @imagepng($dst, $filename);
                //exit();
                break;
            default:
                break;
        }

    }

    /**
     * 圆角矩形
     * @param $imageObj
     * @param $arcRec_SX 开始点X坐标
     * @param $arcRec_SY 开始点Y坐标
     * @param $arcRec_EX 结束点X坐标
     * @param $arcRec_EY 结束点Y坐标
     * @param $redius 圆角半径
     * @param $color 颜色
     */
    function arcRec($imageObj, $arcRec_SX, $arcRec_SY, $arcRec_EX, $arcRec_EY, $redius, $color)
    {
        $arcRec_W = $arcRec_EX - $arcRec_SX;
        $arcRec_H = $arcRec_EY - $arcRec_SY;
        imagefilledrectangle($imageObj, $arcRec_SX + $redius, $arcRec_SY, $arcRec_SX + ($arcRec_W - $redius), $arcRec_SY + $redius, $color);        //矩形一
        imagefilledrectangle($imageObj, $arcRec_SX, $arcRec_SY + $redius, $arcRec_SX + $arcRec_W, $arcRec_SY + ($arcRec_H - ($redius * 1)), $color);//矩形二
        imagefilledrectangle($imageObj, $arcRec_SX + $redius, $arcRec_SY + ($arcRec_H - ($redius * 1)), $arcRec_SX + ($arcRec_W - ($redius * 1)), $arcRec_SY + $arcRec_H, $color);//矩形三
        imagefilledarc($imageObj, $arcRec_SX + $redius, $arcRec_SY + $redius, $redius * 2, $redius * 2, 180, 270, $color, IMG_ARC_PIE);   //四分之一圆 - 左上
        imagefilledarc($imageObj, $arcRec_SX + ($arcRec_W - $redius), $arcRec_SY + $redius, $redius * 2, $redius * 2, 270, 360, $color, IMG_ARC_PIE);   //四分之一圆 - 右上
        imagefilledarc($imageObj, $arcRec_SX + $redius, $arcRec_SY + ($arcRec_H - $redius), $redius * 2, $redius * 2, 90, 180, $color, IMG_ARC_PIE);   //四分之一圆 - 左下
        imagefilledarc($imageObj, $arcRec_SX + ($arcRec_W - $redius), $arcRec_SY + ($arcRec_H - $redius), $redius * 2, $redius * 2, 0, 90, $color, IMG_ARC_PIE);   //四分之一圆 - 右下
    }

    /**
     * @param $imgpath
     * @return array
     * User:五更的猫
     * DateTime:2022/5/9 13:37
     * TODO
     */
    public function yuan_img($imgpath)
    {
        $wh  = getimagesize($imgpath);//pathinfo()不准
        $src_img = null;
        switch ($wh[2]) {
            case 1:
                //gif
                $src_img = imagecreatefromgif($imgpath);
                break;
            case 2:
                //jpg
                $src_img = imagecreatefromjpeg($imgpath);
                break;
            case 3:
                //png
                $src_img = imagecreatefrompng($imgpath);
                break;
        }
        $w   = $wh[0];
        $h   = $wh[1];
        $w   = min($w, $h);
        $h   = $w;
        $img = imagecreatetruecolor($w, $h);
        //这一句一定要有
        imagesavealpha($img, true);
        //拾取一个完全透明的颜色,最后一个参数127为全透明
        $bg = imagecolorallocatealpha($img, 255, 255, 255, 127);
        imagefill($img, 0, 0, $bg);
        $r   = $w / 2; //圆半径
        $y_x = $r; //圆心X坐标
        $y_y = $r; //圆心Y坐标
        for ($x = 0; $x < $w; $x++) {
            for ($y = 0; $y < $h; $y++) {
                $rgbColor = imagecolorat($src_img, $x, $y);
                if (((($x - $r) * ($x - $r) + ($y - $r) * ($y - $r)) < ($r * $r))) {
                    imagesetpixel($img, $x, $y, $rgbColor);
                }
            }
        }
        return [$img,$w];
    }

    /*
     * 根据指定尺寸裁剪目标图片，这里统一转成132*132的
     * 注意第一个参数，为了简便，直接传递的是图片资源，如果是绝对地址图片路径，可以加以改造
     */
    public function get_new_size($imgpath,$new_width,$new_height,$w)
    {
        $image_p = imagecreatetruecolor($new_width, $new_height);//新画布
        $bg = imagecolorallocatealpha($image_p, 255, 255, 255, 127);
        imagefill($image_p, 0, 0, $bg);
        imagecopyresampled($image_p, $imgpath, 0, 0, 0, 0, $new_width, $new_height, $w, $w);
        return $image_p;
    }
}
