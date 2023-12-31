<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

class Files extends _source_Files
{
    /**
     * {@inheritdoc}
     */
    public function beforeDelete(): bool
    {
        if (!parent::beforeDelete()) {
            return false;
        }

        $this->removeFile();

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            'timestamp' => [
                'class'      => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
                'value'      => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * Delete file.
     *
     * @return bool
     */
    public function removeFile(): bool
    {
        if (empty($this->path) || empty($this->file_name)) {
            return false;
        }

        $fileFullName = $this->getPath();

        if (file_exists($fileFullName)) {
            unlink($fileFullName);
            return true;
        }

        return false;
    }

    /**
     * Return path to file.
     *
     * @return string
     */
    public function getPath(): string
    {
        return Yii::getAlias('@root') . "/{$this->path}{$this->file_name}";
    }

    /**
     * Return url to file.
     *
     * @return string
     */
    public function getUrl(): string
    {
        return (Yii::$app->params['domainImg'] ? '//' . Yii::$app->params['domainImg'] : '') . '/' . $this->path . $this->file_name;
    }
}
