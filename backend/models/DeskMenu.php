<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "{{%menu}}".
 *
 * @property integer $menu_id
 * @property string $title
 * @property integer $pid
 * @property string $url
 * @property string $main_css
 * @property integer $sort
 * @property integer $status
 * @property string $group
 * @property integer $append
 * @property integer $updated
 */
class DeskMenu extends ActiveRecord
{
    const STATUS_ON     = 1;       //显示
    const STATUS_OFF    = -1;      //隐藏

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%desk_menu}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'sort', 'append', 'updated'], 'integer'],
            [['title','seo_content','seo_key','url','img','img2','link'],'trim'],
            [['title'],'required'],
            [['title','seo_key','nei_title'], 'string', 'max' => 50],
            [['img','url','img2','link'], 'string', 'max' => 200],
            [['seo_content'], 'string', 'max' => 500],
            ['nei_content', 'string'],
            [['url','link'],'default', 'value' => "#"],

            [['pid','sort'], 'default', 'value' => 0],
            [['level'], 'default', 'value' => 1],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'menu_id'  => 'Menu ID',
            'title'    => '标题',
            'pid'      => '上级id',
            'url'      => '路由',
            'nei_title'=> '內文標題',
            'nei_content' => '內文內容',
            'seo_key'=> 'SEO标题',
            'seo_content'  => 'SEO内容',
            'img'      => '栏目图片',
		    'img2'	   => '手機欄目圖片',
            'link'     => '外链',
            'sort'     => '排序',
            'status'   => '状态',
            'append'   => '创建时间',
            'updated'  => '修改时间',
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
}
