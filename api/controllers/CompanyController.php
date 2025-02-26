<?php
namespace api\controllers;
use yii\web\Response;


/**
 * Site controller
 */
class CompanyController extends MController
{

    public function actions()
    {
        return [
            //接口地址
            'list' => [
                'class' => 'backend\api\company\ListAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],


            'detail' => [
                'class' => 'backend\api\company\DetailAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],


        ];
    }
}
