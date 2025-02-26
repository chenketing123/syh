<?php

namespace backend\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\UserCheck;

/**
 * UserCheckSearch represents the model behind the search form about `backend\models\UserCheck`.
 */
class UserCheckSearch extends UserCheck
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'book_id', 'detail_id', 'status', 'type', 'relation_id', 'check_time'], 'integer'],
            [['image', 'file', 'content', 'file_time','time'], 'safe'],
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
        $query = UserCheck::find();

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
            'user_id' => $this->user_id,
            'book_id' => $this->book_id,
            'detail_id' => $this->detail_id,
            'status' => $this->status,
            'type' => $this->type,
            'relation_id' => $this->relation_id,
            'check_time' => $this->check_time,
        ]);

        if($this->time){
            $query->andFilterWhere(['time'=>strtotime($this->time)]);
        }
        $query->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'file', $this->file])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'file_time', $this->file_time]);

        return $dataProvider;
    }
}
