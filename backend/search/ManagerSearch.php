<?php

namespace backend\search;

use backend\models\Manager;
use Yii;
use yii\base\Model;

/**
 * goods represents the model behind the search form about `backend\models\goods`.
 */
class ManagerSearch extends Manager
{
    public $keywords;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'sex','role_id'], 'integer'],
            [['keywords'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * 产品检索
     */
    public function search($params)
    {
        $query = Manager::find();

        $this->setAttributes($params);

        if (!$this->validate()) {
            return false;
        }
        $query->andFilterWhere([
            'id' => $this->id,
            'sex' => $this->sex,
            'role_id' => $this->role_id,
        ]);

        if(!null==$this->keywords){
            $query->andFilterWhere(['or',['like','username',$this->keywords],['like','realname',$this->keywords],['like','mobile_phone',$this->keywords]]);
        }

        return $query;
    }
}
