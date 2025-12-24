<?php

namespace common\models;

use DateTime;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "seance".
 *
 * @property int $id
 * @property int $film_id
 * @property string $datetime
 * @property int $price
 *
 * @property Film $film
 * @property string $title
 * @property string $rating
 * @property string $photo
 */
class Seance extends ActiveRecord
{
    const SEANCE_GAP = 1800; //минимальный промежуток между сеансами

    const DATABASE_TIME_FORMAT = 'php:Y-m-d H:i:s';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%seance}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['film_id', 'datetime', 'price'], 'required'],
            [['film_id', 'price'], 'default', 'value' => null],
            [['film_id'], 'integer'],
            [['price'], 'integer', 'min' => 1, 'max' => 10000],
            [['film_id'], 'exist', 'skipOnError' => true, 'targetClass' => Film::class, 'targetAttribute' => ['film_id' => 'id']],
            [['datetime'], 'validateDatetime']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Номер',
            'film_id' => 'Фильм',
            'datetime' => 'Дата и время',
            'price' => 'Стоимость (руб)',
            'film' => 'Фильм',
            'rating' => 'Возрастные ограничения',
            'photo' => 'Фото'
        ];
    }

    /**
     * Gets query for [[Film]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFilm()
    {
        return $this->hasOne(Film::class, ['id' => 'film_id']);
    }

    /**
     * Возвращает возрастные ограничения
     *
     * @return string
     */
    public function getRating()
    {
        return $this->film->rating;
    }

    /**
     * Возвращает адрес фотографии фильма
     *
     * @return string
     */
    public function getPhoto()
    {
        return $this->film->photoUrl;
    }

    /**
     * Возвращает название показываемого фильма
     *
     * @return string
     */
    public function getTitle()
    {
        return 'Сеанс ' . Yii::$app->formatter->asDatetime($this->datetime);
    }

    //проверяет, что нет сеансов, расходящихся с данным менее, чем на полчаса
    public function validateDateTime($attribute, $params)
    {
        $value = Yii::$app->formatter->asDatetime($this->datetime, static::DATABASE_TIME_FORMAT);
        $start = new DateTime($value)->getTimestamp();
        //поиск предыдущего сеанса
        $prev = static::find()->where(['<=', 'datetime', $value])->orderBy('datetime DESC')->one();
        if ($prev && $prev->id != $this->id) {
            $prevStart = new DateTime($prev->datetime)->getTimestamp();
            $prevLength = $prev->film->length * 60;
            $diff = $start - $prevStart;
            if ($diff - $prevLength < static::SEANCE_GAP) {
                $prevStartFormatted = Yii::$app->formatter->asDatetime($prevStart);
                $prevEnd = $prevStart + $prevLength;
                $prevEndFormatted = Yii::$app->formatter->asDatetime($prevEnd);
                $this->addError('datetime', 'Сеанс должен начинаться минимум через полчаса после предыдующего, начинающегося в ' .
                   $prevStartFormatted . ' и завершающегося в ' . $prevEndFormatted);
                return;
            }
        }
        //поиск последующего сеанса
        $next = static::find()->where(['>', 'datetime', $value])->orderBy('datetime ASC')->one();
        if ($next && $next->id != $this->id) {
            $nextStart = new DateTime($next->datetime)->getTimestamp();
            $diff = $nextStart - $start;
            if ($diff - $this->film->length * 60 < static::SEANCE_GAP) {
                $nextStartFormatted = Yii::$app->formatter->asDatetime($nextStart);
                $nextEnd = $nextStart + $next->film->length * 60;
                $nextEndFormatted = Yii::$app->formatter->asDatetime($nextEnd);
                $this->addError('datetime', 'Сеанс должен заканчиваться минимум за полчаса до последующего, начинающегося в ' .
                    $nextStartFormatted . ' и завершающегося в ' . $nextEndFormatted);
                return;
            }
        }
        //приведение даты к формату для БД
        $this->datetime = $value;
    }
}
