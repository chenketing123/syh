<?php

namespace backend\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\PracticeUser;

/**
 * PracticeUserSearch represents the model behind the search form about `backend\models\PracticeUser`.
 */
class PracticeUserSearch extends PracticeUser
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'practice_id', 'user_id', 'created_at', 'updated_at'], 'integer'],
            [['file', 'image', 'content', 'file_time'], 'safe'],
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
        $query = PracticeUser::find();

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
            'practice_id' => $this->practice_id,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'file', $this->file])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'file_time', $this->file_time]);

        return $dataProvider;
    }
}
