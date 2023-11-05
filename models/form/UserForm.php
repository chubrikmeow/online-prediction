<?php

namespace app\models\form;

use app\models\User;
use Yii;

class UserForm extends User
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [
                ['username', 'telegram'],
                'filter',
                'filter' => '\yii\helpers\HtmlPurifier::process'
            ], //xss protection
            [['telegram', 'username'], 'required', 'message' => 'Fill in this field.'],
            [['telegram', 'username'], 'string', 'max' => 32],
            [
                'telegram',
                'unique',
                'message' => 'This telegram is already in use.',
            ],
            [
                'username',
                'unique',
                'message' => 'This username is already in use.',
            ],
            [['telegram'], 'filter', 'filter' => function ($value) {
                // Replace special characters with an empty string
                return preg_replace('/[@]/', '', $value);
            }],
        ];
    }

    public function saveData(): bool
    {
        /**
         * @var User $user
         */

        if ($this->validate()) {
            $user = Yii::$app->user->identity;
            $user->username = $this->username;
            $user->telegram = $this->telegram;
            return $user->save();
        }
        return false;
    }
}
