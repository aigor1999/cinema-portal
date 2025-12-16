<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "film".
 *
 * @property int $id
 * @property string $name
 * @property string $photo_type
 * @property string|null $description
 * @property int $length
 * @property string $rating
 *
 * @property Seance[] $seances 
 * @property string $photoUrl
 * @property string $photoPath
 */
class Film extends ActiveRecord
{
    public $upload;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%film}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description'], 'default', 'value' => null],
            [['name', 'photo_type', 'length', 'rating'], 'required'],
            [['description'], 'string'],
            [['length'], 'integer', 'min' => 1, 'max' => 240],
            [['name', 'photo_type'], 'string', 'max' => 255],
            [['rating'], 'string', 'max' => 3],
            [['rating'], 'in', 'range' => ['0+', '6+', '12+', '16+', '18+']],
            [['upload'], 'file', 'extensions' => 'png, jpg', 
                'skipOnEmpty' => !$this->isNewRecord, 'uploadRequired' => 'Необходимо добавить фотографию'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Номер',
            'name' => 'Название',
            'photo_type' => 'Формат фото',
            'description' => 'Описание',
            'length' => 'Длительность (мин)',
            'rating' => 'Возрастные ограничения',
            'photoUrl' => 'Фото',
            'upload' => 'Выбор фото'
        ];
    }

    /**
     * Gets query for [[Seances]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSeances()
    {
        return $this->hasMany(Seance::class, ['film_id' => 'id']);
    }

    /**
     * Gets film photo physical path
     *
     * @return string
     */
    public function getPhotoPath()
    {
        $backendPath = Yii::getAlias('@backend');
        return "$backendPath/web/upload/film/$this->id.$this->photo_type";
    }

    /**
     * Gets film photo url
     *
     * @return string
     */
    public function getPhotoUrl()
    {
        if (basename(Yii::getAlias('@app')) == 'backend')
            return Yii::$app->urlManager->createUrl("upload/film/$this->id.$this->photo_type");
        else
            //относительный URL для обращения из клиентской части через BackendUploadAsset
            return "film/$this->id.$this->photo_type";
    }

    /**
     * Обрабатывает новую фотографию
     *
     * @return string
     */
    public function processUploadData() {
        $this->upload = UploadedFile::getInstance($this, 'upload');
        if (isset($this->upload))
            $this->photo_type = $this->upload->extension;
    }

    /**
     * {@inheritdoc}
     */
    public function afterSave($insert, $changedAttributes)
    {
        //проверка созддания папки upload
        $uploadDir = Yii::getAlias('@backend') . '/web/upload/film';
        if (!is_dir($uploadDir)) {
            FileHelper::createDirectory($uploadDir);
        }
        //проверка символической ссылки во frontend
        /*$frontendDir = Yii::getAlias('@frontend') . '/web/upload';
        if (!is_link($frontendDir)) {
            $realPath = Yii::getAlias('@backend') . '/web/upload';
            symlink($realPath, $frontendDir);
        }*/
        if (!$insert && array_key_exists('photo_type', $changedAttributes)) {
            //удаление предыдущей картинки, если другой формат
            $oldPhotoType = $changedAttributes['photo_type'];
            if ($oldPhotoType != $this->photo_type) {
                $oldPath = "$uploadDir/$this->id.$oldPhotoType";
                FileHelper::unlink($oldPath);
            }
        }
        if (isset($this->upload)) {
            $this->upload->saveAs($this->photoPath);
        }
        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * {@inheritdoc}
     */
    public function afterDelete()
    {
        FileHelper::unlink($this->photoPath);
        parent::afterDelete();
    }

    /**
     * {@inheritdoc}
     */
    public function __tostring()
    {
        return $this->name;
    }

}
