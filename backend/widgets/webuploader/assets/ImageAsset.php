<?php
/**
 *
 * hbshop
 *
 * @package   MultiImageAsset
 * @copyright Copyright (c) 2010-2016, HuiBer
 * @link      http://huiber.cn
 * @author    Alex Liu<lxiangcn@gmail.com>
 */
namespace backend\widgets\webuploader\assets;

use yii\web\AssetBundle;

/**
 * @author Shiyang <dr@shiyang.me>
 */
class ImageAsset extends AssetBundle {

    public $sourcePath = '@backend/widgets/webuploader/statics/';

    public $css = [
        'css/style.css',
        'fancybox/jquery.fancybox.css',//弹出图片css
    ];

    public $js = [
        'js/uploader.js',
        'fancybox/jquery.fancybox.js',//图片弹出js
        '/Public/js/jquery-ui-1.10.4.min.js',//拖动排序
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}