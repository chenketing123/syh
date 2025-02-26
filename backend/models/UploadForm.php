<?php

namespace backend\models;

use yii\base\Model;
use yii\web\UploadedFile;

/**
 * UploadForm is the model behind the upload form.
 */
class UploadForm extends Model
{
    /**
     * @var UploadedFile file attribute
     */
    public $file;
    public $file2;
    public $upload;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['file','file2'], 'file',
                'skipOnEmpty' => true,
                'checkExtensionByMimeType' => false,
                'extensions' => ['xlsx','xls','csv'],
                'wrongExtension'=>'只能上传{extensions}类型文件！'

            ],
            [['upload'], 'file',
                'skipOnEmpty' => true,
                'checkExtensionByMimeType' => false,

            ],

        ];
    }

}


?>