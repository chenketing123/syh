<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use backend\models\Manager;
/**
 * Login form
 */
class RegisterForm extends \common\models\LoginForm
{
    public $email;
    public $mobile_phone;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'match', 'pattern' => '/^[a-z]\w*$/i', 'message' => '{attribute}只能为数字和字母'],
            ['username', 'unique', 'targetClass' => '\backend\modules\member\models\User', 'message' => '此{attribute}已经被使用'],
            ['username', 'string', 'min' => 4, 'max' => 12],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\backend\modules\member\models\User', 'message' => '此{attribute}已经被使用'],

            ['email', 'filter', 'filter' => 'trim'],
            ['mobile_phone', 'required'],
            ['mobile_phone', 'string', 'max' => 20],
            ['mobile_phone','match','pattern'=>'/^[1][3578][0-9]{9}$/','message'=>'不是一个有效的手机号码'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username'      => '账号',
            'password'      => '登录密码',
            'email'         => '邮箱',
            'mobile_phone'  => '手机号码',
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
            $this->_user = Manager::findByUsername($this->username);
        }

        return $this->_user;
    }
}
