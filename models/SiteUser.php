<?php

namespace app\models;

use app\models\traits\DeleteFileTrait;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\db\StaleObjectException;

class SiteUser extends _source_SiteUser
{
    use DeleteFileTrait;

    public const STATUS_INACTIVE = 0;
    public const STATUS_ACTIVE   = 1;

    public const ROLE_ADMIN = 'admin';
    public const ROLE_USER  = 'user';

    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            'timestamp' => [
                'class'      => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'updated_at'
                ],
                'value'      => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @param $insert
     * @param $changedAttributes
     *
     * @throws StaleObjectException
     */
    public function afterSave($insert, $changedAttributes): void
    {
        $this->deleteFileAfterSave($changedAttributes, ['avatar_id']);
        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @return bool
     * @throws StaleObjectException
     */
    public function beforeDelete(): bool
    {
        if (!empty($this->avatar)) {
            $this->avatar->delete();
        }
        return parent::beforeDelete();
    }
}
