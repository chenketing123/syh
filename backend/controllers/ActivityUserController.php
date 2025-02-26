<?php

namespace backend\controllers;

use common\components\CommonFunction;
use Yii;
use backend\search\ActivityUserSearch;
use backend\models\ActivityUser;
use backend\actions\CreateAction;
use backend\actions\UpdateAction;
use backend\actions\IndexAction;
use backend\actions\DeleteAction;
use yii\base\BaseObject;

/**
 * ActivityUserController implements the CRUD actions for ActivityUser model.
 */
class ActivityUserController extends MController
{
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'modelClass' => ActivityUser::className(),
                'data' => function(){
                    
                        $searchModel = new ActivityUserSearch();
                        $dataProvider = $searchModel->search(Yii::$app->getRequest()->getQueryParams());
                        return [
                            'dataProvider' => $dataProvider,
                            'searchModel' => $searchModel,
                        ];
                    
                }
            ],

            'index2' => [
                'class' => IndexAction::className(),
                'modelClass' => ActivityUser::className(),
                'data' => function(){

                    $searchModel = new ActivityUserSearch();
                    $dataProvider = $searchModel->search(Yii::$app->getRequest()->getQueryParams());
                    return [
                        'dataProvider' => $dataProvider,
                        'searchModel' => $searchModel,
                    ];

                }
            ],
            'create' => [
                'class' => CreateAction::className(),
                'modelClass' => ActivityUser::className(),
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => ActivityUser::className(),
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => ActivityUser::className(),
            ],
        ];
    }

    public function actionPay(){
        $id=Yii::$app->request->get('id');
        $model=ActivityUser::findOne($id);
        if($model->pay_status==1){
            $model->pay_status=2;
            $model->paid_time=time();
            $model->save();
            return $this->redirect(Yii::$app->request->referrer);
        }else{
            return $this->message('订单状态不正确',$this->redirect(Yii::$app->request->referrer));
        }

    }


    //导出
    public function actionDaochu(){
        $search=new ActivityUserSearch();
        $data=$search->search(Yii::$app->request->get('message'));
        $count=$data->query->count();
        if( $count==0){
            return $this->redirect(Yii::$app->request->referrer);
        }
        if( $count>10000){

            return $this->message('一次最多导出10000条数据',$this->redirect(Yii::$app->request->referrer),'error');
        }
        $model= $data->query->orderBy('id desc')->all();

        $head = array(
            array('1', '姓名'),
            array('2', '手机'),
            array('3', '书籍'),
            array('4', '章节'),
            array('5', '时间'),
            array('6', '状态'),
            array('7', '小组/团队'),
            array('8', '文件'),
            array('9', '内容'),
            array('10', '图片'),
            array('11', '签到时间'),
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

            $dataArr = $model;

            foreach ($dataArr as $k => $v) {
                $cnt++;
                if ($limit == $cnt) {
                    //刷新一下输出buffer，防止由于数据过多造成问题
                    ob_flush();
                    //flush();
                    $cnt = 0;
                }
                $list = array();
                $list['1'] = $v->user['name'];
                $list['2'] =$v->user['mobile_phone'];
                $list['3'] = $v->book['title'];
                if($v->detail['number2']>0){
                    $detail= $v->detail['number1'].'章'. $v->detail['number2'].'节';
                }else{
                    $detail= $v->detail['number1'].'章';
                }
                $list['4'] = $detail;
                $list['5']=date('Y-m-d',$v['time']);
                $list['6']=\backend\models\UserCheck::$status_message[$v->status];
                $list['7']=$v->team['title'];
                $list['8']=CommonFunction::setImg($v->file);
                $list['9']=$v->content;
                $list['10']=CommonFunction::setImg($v->image);

                $check_time='';
                if($v->check_time>0){
                    $check_time= date('Y-m-d H:i:s',$v->check_time);
                }
                $list['11']=$check_time;

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
            return $this->redirect($url);
        }
    }


}
