<?php

namespace frontend\assets;
use yii\helpers\FileHelper;
use yii\web\AssetBundle;

/**
 *
 * Asset for backend uploads.
 */
class BackendUploadAsset extends AssetBundle
{
    /**
     * {@inheritdoc}
     */
    public $sourcePath = '@backend/web/upload/film';

    /**
     * {@inheritdoc}
     */
    public function init() {
        parent::init();
        //проверка создания папки upload
        $uploadDir = $this->sourcePath;
        if (!is_dir($uploadDir)) {
            FileHelper::createDirectory($uploadDir);
        }
    }
}