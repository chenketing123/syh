<?php
/**
 * 多图上传
 */
namespace backend\widgets\webuploader;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\InputWidget;
use backend\widgets\webuploader\assets\ImageAsset;
use backend\widgets\webuploader\assets\WebuploaderAsset;

/**
 * 多图上传
 */
class Image extends InputWidget
{

    /**
     * @var array
     * 基础属性
     */
    public $options = [];

    /**
     * @var array
     * 更多属性
     */
    public $pluginOptions = [];

    /**
     * @var
     * 盒子ID
     */
    public $boxId;

    /**
     * @var string
     * 默认名称
     */
    public $name = 'fileinput';

    /**
     * @var string
     */
    public $value = '';

    /**
     * 隐藏按钮
     */
    protected $hiddenInput;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $_options = [
            'multiple'   => true,
            'mimeTypes'  => 'image/*',
            'extensions' => 'gif,jpg,jpeg,bmp,png',
        ];

        $_pluginOptions = [
            'uploadUrl'        => Url::to(['/file2/upload-images']),
            'uploadMaxSize'    => 1024 * 5,
            'previewWidth'     => '112',
            'previewHeight'    => '112',
        ];

        $this->options = ArrayHelper::merge($_options, $this->options);
        $this->pluginOptions = ArrayHelper::merge($_pluginOptions, $this->pluginOptions);

        if ($this->hasModel())
        {
            $this->hiddenInput = Html::activeHiddenInput($this->model, $this->attribute);
        }
        else
        {
            $this->hiddenInput = Html::hiddenInput($this->name, $this->value);
        }
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $this->registerClientScript();

        $attribute = str_replace("[]","",$this->attribute);

        $value = trim($this->hasModel() ? Html::getAttributeValue($this->model, $attribute) : $this->value);

        return $this->render('index', [
            'name'          => $this->name!=="fileinput"? $this->name:Html::getInputName($this->model, $this->attribute),
            'value'         => $this->options['multiple'] == true ? explode(',',$value) : $value,
            'options'       => $this->options,
            'boxId'         => $this->boxId,
            'pluginOptions' => $this->pluginOptions,
            'hiddenInput'   => $this->hiddenInput,
        ]);
    }

    /**
     * 注册资源
     */
    protected function registerClientScript()
    {
        $view = $this->getView();
        WebuploaderAsset::register($view);
        ImageAsset::register($view);
    }
}