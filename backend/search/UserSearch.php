<?php

namespace backend\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\User;

/**
 * UserSearch represents the model behind the search form about `backend\models\User`.
 */
class UserSearch extends User
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'sex', 'type', 'created_at', 'updated_at', 'end_time', 'status', 'task', 'age', 'is_vip', 'start_time'], 'integer'],
            [['name', 'mobile_phone', 'company_phone', 'head_image', 'password', 'douyin', 'company', 'business', 'company_image'], 'safe'],
            [['integral'], 'number'],
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
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = User::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
                'sort' => [
                    'defaultOrder' => [
                        'id'=>SORT_DESC,
                    ]
                ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'sex' => $this->sex,
            'type' => $this->type,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'integral' => $this->integral,
            'end_time' => $this->end_time,
            'status' => $this->status,
            'task' => $this->task,
            'age' => $this->age,
            'is_vip' => $this->is_vip,
            'start_time' => $this->start_time,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'mobile_phone', $this->mobile_phone])
            ->andFilterWhere(['like', 'company_phone', $this->company_phone])
            ->andFilterWhere(['like', 'head_image', $this->head_image])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'douyin', $this->douyin])
            ->andFilterWhere(['like', 'company', $this->company])
            ->andFilterWhere(['like', 'business', $this->business])
            ->andFilterWhere(['like', 'company_image', $this->company_image]);

        return $dataProvider;
    }
}
