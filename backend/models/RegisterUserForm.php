<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use backend\models\User;
/**
 * Login form
 */
class RegisterUserForm extends \common\models\LoginForm
{

    public static function tableName()
    {
        return '{{%user}}';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\backend\models\User', 'message' => '此{attribute}已经被使用'],
            ['username', 'string', 'min' => 4, 'max' => 12],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username'      => '账号',
            'password'      => '登录密码',
        ];
    }

    /**
     * @param $attribute
     * @param $params
     */
    public function validateUser($attribute)
    {
        if($this->getUser()){
            if($this->_user){
                $this->addError($attribute,'该账号已经被注册');
            }
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
