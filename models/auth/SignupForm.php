<?php

namespace app\models\auth;

use app\models\User;
use himiklab\yii2\recaptcha\ReCaptchaValidator2;
use Yii;
use yii\base\Exception;
use yii\base\Model;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $telegram;
    public $password;
    public $password_repeat;
    public $user;
    public $reCaptcha;

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['telegram', 'username'], 'required', 'message' => 'Fill in this field.'],
            [['telegram', 'username'], 'string', 'max' => 32],
            [
                'telegram',
                'unique',
                'targetClass' => User::class,
                'message'     => 'This telegram is already in use.',
                'filter'      => ['status' => [User::STATUS_ACTIVE, User::STATUS_INACTIVE]]
            ],
            [
                'username',
                'unique',
                'targetClass' => User::class,
                'message'     => 'This username is already in use.',
                'filter'      => ['status' => [User::STATUS_ACTIVE, User::STATUS_INACTIVE]]
            ],

            [['telegram'], 'filter', 'filter' => function ($value) {
                // Replace special characters with an empty string
                return preg_replace('/[@]/', '', $value);
            }],

            ['password', 'required', 'message' => 'Fill in this field.'],
            ['password', 'string', 'min' => 6, 'tooShort' => 'The password must contain at least 6 characters.'],

            ['password_repeat', 'required', 'message' => 'Fill in this field.'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => "Password mismatch."],

            [
                ['reCaptcha'],
                ReCaptchaValidator2::class,
                'uncheckedMessage' => 'Please confirm that you are not a bot.'
            ],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     * @throws Exception
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = User::findOne(['username' => $this->username, 'status' => User::STATUS_ACTIVE]);
            if (!$user) {
                $user = new User();
                $user->status = User::STATUS_ACTIVE;
                $user->role = User::ROLE_USER;
                $user->username = $this->username;
                $user->telegram = $this->telegram;
                $user->points = 50000;
                $user->user_ip = Yii::$app->request->userIP;
                $user->generateAuthKey();
            }

            $user->setPassword($this->password);

            if ($user->save()) {
                $this->user = $user;
                return $user;
            }

            if ($errors = $user->getErrors()) {
                foreach ($errors as $key => $mess) {
                    if ($key === "username") {
                        $this->addError($key, $mess[0]);
                    }
                }
            }
        }

        return null;
    }
}
