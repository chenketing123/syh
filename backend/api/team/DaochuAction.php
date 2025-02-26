<?php

namespace backend\api\team;
use backend\models\Team;
use backend\models\TeamDetail;
use backend\models\User;
use backend\models\UserCheck;
use backend\models\UserTeam;
use common\base\api\CommonApiAction;
use common\components\CommonFunction;
use common\components\Helper;
use common\exception\ApiException;
use Yii;
use yii\base\BaseObject;


class DaochuAction extends CommonApiAction
{
    public $isSign=true;
    public $isLogin=true;

    protected function runAction()
    {

        $user_id=$this->user['id'];


        $user_team=UserTeam::find()->where(['type'=>2,'user_id'=>$user_id])->limit(1)->one();
        if(!$user_team){
            throw new ApiException('您未加入团队', 1);
        }
        if($user_team->user_type==1){
            throw new ApiException('您没有该权限', 1);
        }
        $detail_id=$this->RequestData('detail_id','');
        $query=UserTeam::find()->where(['team_id'=>$user_team->team_id])->andFilterWhere(['detail_id'=>$detail_id]);
        $start_time=$this->RequestData('start_time','');
        $end_time=$this->RequestData('end_time','');
        $data_list=[];
        $model=$query->orderBy('user_type desc,sort asc,id desc')->all();
        foreach ($model as $k=>$v){
            $user=User::findOne($v['user_id']);
            if($user){
                $detail_title='';
                if($v->detail_id>0){
                    $detail=TeamDetail::findOne($v['detail_id']);
                    if($detail){
                        $detail_title=$detail->title;
                    }
                }
                if($start_time and $end_time){
                    $start=strtotime($start_time);
                    $end=strtotime($end_time)+24*3600-1;
                    $number=UserCheck::find()->where(['relation_id'=>$v['team_id'],'user_id'=>$v['user_id'],'status'=>2])->andWhere(['>=','time',$start])
                        ->andWhere(['<=','time',$end])->count();
                }else{
                    $number=UserCheck::find()->where(['relation_id'=>$v['team_id'],'user_id'=>$v['user_id'],'status'=>2])->count();
                }
                $data_list[]=[
                    'user_id'=>$user['id'],
                    'user_name'=>$user['name'],
                    'user_type'=>$v['user_type'],
                    'head_image'=>CommonFunction::setImg($user['head_image']),
                    'number'=>$number,
                    'mobile'=>$user['mobile_phone'],
                    'detail_title'=>$detail_title
                ];
            }

        }


        ini_set('memory_limit', '2048M');    // 临时设置最大内存占用为2G
        set_time_limit(0);

        $type=Yii::$app->request->post('daochu',1);
        if($type==1){
            $count=count($data_list);
            if($count>20000){
                throw new ApiException('一次最多导出2W条数据',1);
            }
            $head = array(
                array('1', '姓名'),
                array('2', '手机'),
                array('3', '打卡次数'),
                array('4', '类型'),
                array('5', '分组'),

            );

            $fileName='file';
            $sqlCount = 1;
            $arr = array();
            $arr2 = array();
            foreach ($head as $k => $v) {
                $arr[$k] = $v[1];
                $arr2[$k] = $v[0];
            }

            $sqlLimit = 100000;//每次只从数据库取100000条以防变量缓存太大
            // 每隔$limit行，刷新一下输出buffer，不要太大，也不要太小
            $limit = 10000;
            // buffer计数器
            $cnt = 0;
            $fileNameArr = array();
            $objArr = array();

            // 逐行取出数据，不浪费内存
            $rand =date('YmdHis');
            for ($i = 0; $i < ceil($sqlCount / $sqlLimit); $i++) {

                $fp = fopen(Yii::getAlias('@staticroot') . '/' . $fileName . '_' . $rand . '.csv', 'w'); //生成临时文件
                chmod(Yii::getAlias('@staticroot') . '/' . $fileName . '_' . $rand . '.csv', 0777);//修改可执行权限
                $fileNameArr[] = Yii::getAlias('@staticroot') . '/' . $fileName . '_' . $rand . '.csv';

                //设置utf8编码
                fprintf($fp, chr(0xEF) . chr(0xBB) . chr(0xBF));
                // 将数据通过fputcsv写到文件句柄
                fputcsv($fp, $arr, ',');

                $dataArr = $data_list;

                foreach ($dataArr as $k => $v) {
                    $cnt++;
                    if ($limit == $cnt) {
                        //刷新一下输出buffer，防止由于数据过多造成问题
                        ob_flush();
                        //flush();
                        $cnt = 0;
                    }
                    $list = array();
                    $list['1'] = $v['user_name'];
                    $list['2'] = $v['mobile'];
                    $list['3'] = $v['number'];
                    if($v['user_type']==1){
                        $list['4'] = '普通团员';
                    }elseif ($v['user_type']==2){
                        $list['4'] = '团委';
                    }else{
                        $list['4'] = '团长';
                    }
                    $list['5'] = $v['detail_title'];
                    $dataarr = array();
                    foreach ($arr2 as $kk => $vv) {
                        $dataarr[$kk] = $list[$vv];
                    }
                    unset($list);
                    fputcsv($fp, $dataarr, ',');
                    unset($dataarr);
                }
                unset($dataArr);
                fclose($fp);  //每生成一个文件关闭
                unset($fp);
                $url = Yii::$app->request->hostInfo.Yii::getAlias('@static') . '/' . $fileName . '_' . $rand . '.csv';
                $jsonData['url']=$url;
            }
        }
        $jsonData['errmsg']='';
        return $jsonData;
    }
}