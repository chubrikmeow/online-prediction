<?php

namespace app\models\ban;

use app\models\User;
use yii\base\Exception;
use yii\base\Model;

/**
 * Ban form
 */
class BanForm extends Model
{
    public $username;

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['username'], 'required', 'message' => 'Fill in this field.'],
        ];
    }

    /**
     * Ban.
     *
     * @return User|null the saved model or null if saving fails
     * @throws Exception
     */
    public function ban()
    {
        if ($this->validate()) {
            $user = User::findOne(['username' => $this->username]);

            if ($user) {
                $user->status = User::STATUS_INACTIVE;
                $user->points = 0;
                $user->save();
            }

            return true;
        }

        return null;
    }
}
