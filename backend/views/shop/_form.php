<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Shop */
/* @var $form yii\widgets\ActiveForm */
?>
<script type="text/javascript">
    window._AMapSecurityConfig = {
        securityJsCode: "efb2e47537aec8c724fa4980b5445e15",
    }
</script>

<div class="shop-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'city')->dropDownList(\backend\models\ShopCity::getList()) ?>

    <?= $form->field($model, 'image')->widget('backend\widgets\webuploader\Image', [
        'boxId' => 'image',
        'options' => [
            'multiple' => false,
        ]
    ]) ?>

    <?= $form->field($model, 'lng')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lat')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?>




    <label>输入搜索或点击图片确定经纬度</label>
    <input id="tipinput" type="text" >
    <div id="container" style="width: 800px;height: 800px"></div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '添加' : '保存', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>


    <?php ActiveForm::end(); ?>




</div>







<script src="https://webapi.amap.com/maps?v=2.0&key=515820ffd6c076342d8ef56ed3e8b90e&plugin=AMap.Autocomplete"></script>
<script type="text/javascript">
    var map = new AMap.Map("container", {
        zoom: 12,
        resizeEnable: true
    });
    //为地图注册click事件获取鼠标点击出的经纬度坐标
    map.on('click', function(e) {

        document.getElementById("shop-lng").value = e.lnglat.getLng();
        document.getElementById("shop-lat").value =  e.lnglat.getLat();
        var marker = new AMap.Marker({
            position: new AMap.LngLat(e.lnglat.getLng(), e.lnglat.getLat()),   // 经纬度对象，也可以是经纬度构成的一维数组[116.39, 39.9]
            title: '标记'
        });


        map.clearMap();
        map.add(marker);

    });


    //输入提示
    var autoOptions = {
        input: "tipinput"
    };

    AMap.plugin(['AMap.PlaceSearch','AMap.AutoComplete'], function(){
        var auto = new AMap.AutoComplete(autoOptions);
        var placeSearch = new AMap.PlaceSearch({
            map: map
        });  //构造地点查询类
        auto.on("select", select);//注册监听，当选中某条记录时会触发
        function select(e) {

            placeSearch.setCity(e.poi.adcode);
            placeSearch.search(e.poi.name);  //关键字查询查询

            document.getElementById("shop-lng").value = e.poi.location.lng;

            document.getElementById("shop-lat").value = e.poi.location.lat;
            var marker = new AMap.Marker({
                position: new AMap.LngLat(e.poi.location.lng, e.poi.location.lat),   // 经纬度对象，也可以是经纬度构成的一维数组[116.39, 39.9]
                title: '标记'
            });

            map.clearMap();
            map.add(marker);
        }
    });





</script>
