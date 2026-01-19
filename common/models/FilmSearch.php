<?php

namespace common\models;

use yii\data\ActiveDataProvider;

/**
 * FilmSearch short summary.
 *
 * FilmSearch description.
 *
 * @version 1.0
 * @author User
 */
class FilmSearch extends Film
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'rating'], 'safe'],
            [['length'], 'integer']
        ];
    }

    public function search($params)
    {
        $query = Film::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
            */
        ]);

        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['length' => $this->length])
            ->andFilterWhere(['rating' => $this->rating]);

        return $dataProvider;
    }
}