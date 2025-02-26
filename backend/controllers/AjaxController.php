<?php

namespace backend\controllers;

use backend\models\AuthItem;
use backend\models\Customer;
use backend\models\Goods;
use backend\models\GoodsCategoryAttributes;
use backend\models\PlaceOrder;
use backend\models\Terminal;
use backend\models\User;
use Yii;


/**
 * OrderController implements the CRUD actions for Order model.
 */
class AjaxController extends MController
{
    public function actionAjaxStatus()
    {
        $id = Yii::$app->request->get('id');
        $model = Yii::$app->request->get('model');
        $attribute = Yii::$app->request->get('attribute');
        if ($id and $model and $attribute) {
            $data = call_user_func([$model, 'findOne'], $id);
            if (isset($data[$attribute])) {
                if ($data[$attribute] == 1) {
                    $data[$attribute] = 0;
                } else {
                    $data[$attribute] = 1;
                }
                if ($data->save()) {
                    return 0;
                };
            }
        }
        return 1;

    }

    public function actionCategory(){
        $get=Yii::$app->request->get();
        $goods_id=$get['goods_id'];
        $id=$get['id'];
        $html='';

        return json_encode($html);
    }

    public function actionGetCustomer()
    {
        $name = Yii::$app->request->get('name');
        $model = Customer::findOne(['name' => $name]);
        $data = [
            'mobile' => $model->mobile,
            'address' => $model->address,
        ];
        return json_encode($data);
    }


    public function actionGetMessage()
    {
        if (Yii::$app->user->identity->id != Yii::$app->params['adminAccount']) {
            $permissionName = 'place_order/index';
            $model = AuthItem::find()->where(['name' => $permissionName, 'type' => 2])->one();
            if (!$model) {
                return 0;
            }
        }
        $cg_number=PlaceOrder::find()->where(['status'=>1])->count();
        if($cg_number>0){
            return 1;
        }
    }


    public function actionGetUser($q){


        $out=['results'=>['id'=>'','text'=>'']];
        if(!$q){
            return json_encode($out);
        }
        $data=User::find()->select('id,name as text')
            ->andFilterWhere(['like','name',$q])->limit(20)->asArray()->all();
        $out['results']=array_values($data);
        return json_encode($out);

    }


}
