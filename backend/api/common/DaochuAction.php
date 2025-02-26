<?php

namespace backend\api\common;
use backend\models\Accident;
use backend\models\Car;
use backend\models\DeviceHistory;
use backend\models\Question;
use backend\models\User;
use backend\models\UserDevice;
use backend\search\GoodsSearch;
use backend\search\NewsSearch;
use backend\search\OrderSearch;
use backend\search\UserSearch;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;

class DaochuAction extends ManagerApiAction
{


    public $isSign=true;
    public $isLogin=true;
    protected function runAction()
    {
        ini_set('memory_limit', '2048M');    // 临时设置最大内存占用为2G
        set_time_limit(0);

        $type=Yii::$app->request->post('daochu',1);
        if($type==1){
            $searchModel = new UserSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->post());
            $count=$dataProvider->query->count()*1;
            if($count>20000){
                throw new ApiException('一次最多导出2W条数据',1);
            }
            $model=$dataProvider->query->orderBy('id desc')->all();
            $head = array(
                array('1', 'ID'),
                array('2', '名称'),
                array('3', '手机'),
                array('4', '性别'),
                array('5', '积分'),
                array('6', '类型'),
                array('7', '抖音号'),
                array('8', '注册时间'),
            );

            $fileName='user';
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
                    $list['1'] = $v['id'];
                    $list['2'] = $v['name'];
                    $list['3'] = $v['mobile_phone'];
                    if($v['sex']==1){
                        $list['4']='男';
                    }elseif ($v['sex']==2){
                        $list['4']='女';
                    }else{
                        $list['4']='未知';
                    }
                    $list['5'] = $v['integral'];
                    if($v['type']==2){
                        $list['6'] = '已关注';
                    }else{
                        $list['6'] = '未关注';
                    }
                    $list['7'] = $v['douyin'];
                    $list['8'] = date('Y-m-d H:i',$v['created_at']);
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
        elseif($type==2){
            $searchModel = new GoodsSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->post());
            $count=$dataProvider->query->count()*1;
            if($count>20000){
                throw new ApiException('一次最多导出2W条数据',1);
            }
            $model=$dataProvider->query->orderBy('id desc')->all();
            $head = array(
                array('1', 'ID'),
                array('2', '名称'),
                array('3', '积分'),
                array('4', '库存'),
            );

            $fileName='goods';
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
                    $list['1'] = $v['id'];
                    $list['2'] = $v['title'];
                    $list['3'] = $v['price'];
                    $list['4'] = $v['number'];
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
        elseif($type==3){
            $searchModel = new OrderSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->post());
            $count=$dataProvider->query->count()*1;
            if($count>20000){
                throw new ApiException('一次最多导出2W条数据',1);
            }
            $model=$dataProvider->query->orderBy('id desc')->all();
            $head = array(
                array('1', 'ID'),
                array('2', '订单编号'),
                array('3', '收货人'),
                array('4', '电话'),
                array('5', '省'),
                array('6', '市'),
                array('7', '区'),
                array('8', '详情地址'),
                array('9', '所需积分'),
                array('10', '状态'),
                array('11', '备注'),
                array('12', '快递方式'),
                array('13', '快递单号'),
                array('14', '添加时间'),
            );

            $fileName='order';
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
                    $list['1'] = $v['id'];
                    $list['2'] = $v['order_number'];
                    $list['3'] = $v['contact'];
                    $list['4'] = $v['phone'];
                    $list['5'] = $v['province'];
                    $list['6'] = $v['city'];
                    $list['7'] = $v['area'];
                    $list['8'] = $v['address'];
                    $list['9'] = $v['total_price'];
                    $status_message=[
                        1=>'待审核',
                        2=>'审核通过',
                        3=>'驳回',
                    ];
                    $list['10'] = $status_message[$v['status']];
                    $list['11'] = $v['content'];
                    $list['12'] = $v['express'];
                    $list['13'] = $v['express_number'];
                    $list['14'] = date('Y-m-d H:i',$v['created_at']);
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
        elseif($type==4){
            $searchModel = new NewsSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->post());
            $count=$dataProvider->query->count()*1;
            if($count>20000){
                throw new ApiException('一次最多导出2W条数据',1);
            }
            $model=$dataProvider->query->orderBy('id desc')->all();
            $head = array(
                array('1', 'ID'),
                array('2', '标题'),
                array('3', '副标题'),
                array('4', '添加时间'),
            );

            $fileName='news';
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
                    $list['1'] = $v['id'];
                    $list['2'] = $v['title'];
                    $list['3'] = $v['subtitle'];
                    $list['4'] =date('Y-m-d H:i',$v['created_at']);

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
        elseif($type==5){
            $query = Question::find()->filterWhere(['like','title',$this->RequestData('title')]);
            $count=$query->count()*1;
            if($count>20000){
                throw new ApiException('一次最多导出2W条数据',1);
            }
            $model=$query->orderBy('id desc')->all();
            $head = array(
                array('1', 'ID'),
                array('2', '问题'),
                array('3', '答案'),
                array('4', '正确答案'),
            );

            $fileName='question';
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
                    $list['1'] = $v['id'];
                    $list['2'] = $v['title'];
                    $list['3'] = implode(',',unserialize($v['answer']));
                    $list['4'] =$v['correct'];

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
        elseif($type==6){
            $query = Car::find()->filterWhere(['like','car_number',$this->RequestData('car_number')]);
            $count=$query->count()*1;
            if($count>20000){
                throw new ApiException('一次最多导出2W条数据',1);
            }
            $model=$query->orderBy('id desc')->all();
            $head = array(
                array('1', 'ID'),
                array('2', '车牌号'),
                array('3', '类型'),
                array('4', '品牌'),
                array('5', '车型'),
                array('6', '车架号'),
                array('7', '保险公司'),
                array('8', '用户'),

            );

            $fileName='car';
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
                    $list['1'] = $v['id'];
                    $list['2'] = $v['car_number'];
                    $type_message=[
                        1=>'油车',
                        2=>'电车'
                    ];
                    $list['3'] = $type_message[$v['type']];
                    $list['4'] =$v['brand'];
                    $list['5'] =$v['car_type'];
                    $list['6'] =$v['insurer'];
                    $list['7'] =$v['frame'];
                    $user=User::findOne($v['user_id']);
                    $list['8'] =$user['name'];

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
        elseif($type==7){
            $user_id=Yii::$app->request->post('user_id');
            $direction=Yii::$app->request->post('direction');
            $location=$this->RequestData('location');
            $type=Yii::$app->request->post('type');
            $road=Yii::$app->request->post('road');
            $query=Accident::find()->filterWhere(['user_id'=>$user_id])->andFilterWhere(['like','direction',$direction])
                ->andFilterWhere(['like','direction',$direction])  ->andFilterWhere(['like','location',$location])
                ->andFilterWhere(['type'=>$type])->andFilterWhere(['road'=>$road]);
            $count=$query->count()*1;
            if($count>20000){
                throw new ApiException('一次最多导出2W条数据',1);
            }
            $model=$query->orderBy('id desc')->all();
            $head = array(
                array('1', 'ID'),
                array('2', '用户'),
                array('3', '类型'),
                array('4', '道路选择'),
                array('5', '行驶方向'),
                array('6', '位置'),
                array('7', '经度'),
                array('8', '纬度'),
                array('9', '占用车道'),
                array('10', '车牌号'),
                array('11', '添加时间'),

            );

            $fileName='jy';
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
                    $list['1'] = $v['id'];
                    $user=User::findOne($v['user_id']);
                    $list['2'] = $user['name'];
                    $type_message=[
                        1=>'事故',
                        2=>'抛锚'
                    ];
                    $list['3'] = $type_message[$v['type']];
                    $road_message=[
                        1=>'高速',
                        2=>'高速(快速路)',
                        3=>'普通道路'
                    ];
                    $list['4'] =$road_message[$v['road']];
                    $list['5'] =$v['direction'];
                    $list['6'] =$v['location'];
                    $list['7'] =$v['lng'];
                    $list['8'] =$v['lat'];
                    $list['9'] =$v['occupy'];
                    $list['10'] =$v['car_number'];
                    $list['11'] =date('Y-m-d H:i',$v['created_at']);

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
        elseif($type==8){
            $start_time=$this->RequestData('start_time');
            $end_time=$this->RequestData('end_time');
            $user_id=Yii::$app->request->post('user_id');
            $query=UserDevice::find()->filterWhere(['user_id'=>$user_id])->andFilterWhere(['like','title',$this->RequestData('title')]);
            if ($start_time) {
                $query->andFilterWhere(['>=', 'created_at', strtotime($start_time)]);
            }
            if ($end_time) {
                $query->andFilterWhere(['<', 'created_at', strtotime($end_time) + 24 * 3600 - 1]);
            }
            $count=$query->count()*1;
            if($count>20000){
                throw new ApiException('一次最多导出2W条数据',1);
            }
            $model=$query->orderBy('id desc')->all();
            $head = array(
                array('1', 'ID'),
                array('2', '设备标题'),
                array('3', '用户'),
                array('4', '添加时间'),
            );

            $fileName='shebei';
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
                    $list['1'] = $v['id'];
                    $list['2'] = $v['title'];
                    $user=User::findOne($v['user_id']);
                    $list['3'] = $user['name'];
                    $list['4'] =date('Y-m-d H:i',$v['created_at']);

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
        elseif($type==9){
            $start_time=$this->RequestData('start_time');
            $end_time=$this->RequestData('end_time');
            $user_id=Yii::$app->request->post('user_id');
            $query=DeviceHistory::find()->filterWhere(['user_id'=>$user_id])->andFilterWhere(['like','title',$this->RequestData('title')]);
            if ($start_time) {
                $query->andFilterWhere(['>=', 'created_at', strtotime($start_time)]);
            }
            if ($end_time) {
                $query->andFilterWhere(['<', 'created_at', strtotime($end_time) + 24 * 3600 - 1]);
            }
            $count=$query->count()*1;
            if($count>20000){
                throw new ApiException('一次最多导出2W条数据',1);
            }
            $model=$query->orderBy('id desc')->all();
            $head = array(
                array('1', 'ID'),
                array('2', '设备标题'),
                array('3', '用户'),
                array('4', '添加时间'),
            );

            $fileName='shebeijl';
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
                    $list['1'] = $v['id'];
                    $list['2'] = $v['title'];
                    $user=User::findOne($v['user_id']);
                    $list['3'] = $user['name'];
                    $list['4'] =date('Y-m-d H:i',$v['created_at']);

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
        else{
            throw new ApiException('type不正确',1);
        }

        $jsonData['errmsg']='';
        return $jsonData;
    }

}