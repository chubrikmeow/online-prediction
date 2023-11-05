<?php

namespace app\models\ban;

use app\models\User;
use yii\base\Exception;
use yii\base\Model;

/**
 * Unban form
 */
class UnbanForm extends Model
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
     * Unban.
     *
     * @return User|null the saved model or null if saving fails
     * @throws Exception
     */
    public function unban()
    {
        if ($this->validate()) {
            $user = User::findOne(['username' => $this->username]);

            if ($user) {
                $user->status = User::STATUS_ACTIVE;
                $user->points = 50000;
                $user->save();
            }

            return true;
        }

        return null;
    }
}
