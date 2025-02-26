<?php

namespace backend\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\UserMessage;

/**
 * UserMessageSearch represents the model behind the search form about `backend\models\UserMessage`.
 */
class UserMessageSearch extends UserMessage
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'message_id', 'number', 'user_id', 'created_at', 'updated_at'], 'integer'],
            [['company'], 'safe'],
            [['money', 'scale'], 'number'],
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
        $query = UserMessage::find();

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
            'message_id' => $this->message_id,
            'money' => $this->money,
            'number' => $this->number,
            'scale' => $this->scale,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'company', $this->company]);

        return $dataProvider;
    }
}
