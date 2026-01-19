<?php

namespace common\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * SeanceSearch short summary.
 *
 * SeanceSearch description.
 *
 * @version 1.0
 * @author User
 */
class SeanceSearch extends Seance
{
    public $name;
    public $rating;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'datetime', 'rating'], 'safe'],
            [['price'], 'integer']
        ];
    }

    public function search($params)
    {
        $query = Seance::find()->orderBy(['datetime' => SORT_DESC])->joinWith(['film']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            /*
            'pagination' => [
                'pageSize' => 50
            ],
            */
            'sort' => false,
        ]);

        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        $datetime = $this->datetime ? Yii::$app->formatter->asDatetime($this->datetime, static::DATABASE_TIME_FORMAT) : '';

        $query->andFilterWhere(['like', 'film.name', $this->name])
            ->andFilterWhere(['datetime' => $datetime])
            ->andFilterWhere(['price' => $this->price])
            ->andFilterWhere(['film.rating' => $this->rating]);

        return $dataProvider;
    }
}