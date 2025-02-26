<?php
use frontend\assets\AppAsset;
use yii\helpers\Html;
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,user-scalable=no,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0">

    <meta name="keywords" content="<?= Yii::$app->config->info('WEB_SITE_KEYWORD') ?>" />
    <meta name="description" content="<?= Yii::$app->config->info('WEB_SITE_DESCRIPTION') ?>" />
    <title><?php echo  Yii::$app->config->info('WEB_SITE_TITLE') ?></title>


    <?= Html::csrfMetaTags() ?>



    <?php $this->head() ?>
</head>

<body>
<!--massage提示-->
<div style="display: none">
    <?php
    $session = \Yii::$app->session;
    $flashes = $session->getAllFlashes();
    if(count($flashes)>0){
        $message='';
        foreach ($flashes as $k=>$v){
            $message.=$v;
        }
        ?>
        <script>
            alert('<?php echo $message?>');
        </script>
    <?php }?>
</div>

<!--massage提示-->
<?php $this->beginBody() ?>
<?= $content ?>
<?= \frontend\widgets\FooterWidget::widget();?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
