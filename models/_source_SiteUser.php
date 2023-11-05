<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property int $status
 * @property string $role
 * @property string $username
 * @property string $telegram
 * @property string|null $auth_key
 * @property string|null $password_hash
 * @property int|null $avatar_id
 * @property int|null $points
 * @property string|null $user_ip
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Files $avatar
 */
class _source_SiteUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'role', 'username', 'telegram'], 'required'],
            [['status', 'avatar_id', 'points'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['username', 'telegram'], 'string', 'max' => 32],
            [['role', 'auth_key', 'password_hash', 'user_ip'], 'string', 'max' => 64],
            [['username'], 'unique'],
            [['telegram'], 'unique'],
            [['avatar_id'], 'exist', 'skipOnError' => true, 'targetClass' => Files::class, 'targetAttribute' => ['avatar_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status' => 'Status',
            'role' => 'Role',
            'username' => 'Username',
            'telegram' => 'Telegram',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'avatar_id' => 'Avatar ID',
            'points' => 'Points',
            'user_ip' => 'User Ip',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Avatar]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAvatar()
    {
        return $this->hasOne(Files::class, ['id' => 'avatar_id']);
    }
}
