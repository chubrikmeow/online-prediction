<?php

namespace app\models\prediction;

use app\models\Prediction;
use app\models\PredictionBet;
use app\models\User;
use Yii;
use yii\base\Exception;
use yii\base\Model;

/**
 * Prediction bet ne okup form
 */
class PredictionBetNeOkupForm extends Model
{
    public $username;
    public $points;
    public $userBet;

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['points'], 'required', 'message' => 'Fill in this field.'],
            [
                ['points'], 
                'integer', 'message' => 'Enter the number of points.',
                'max' => Yii::$app->user->identity->points, 'tooBig' => 'You don`t have enough points.', 
                'min' => 1, 'tooSmall' => 'You must give at least 1 point.'
            ],
            [
                'username',
                'unique',
                'targetClass' => User::class,
                'message'     => 'You`ve already made your prediction!',
                'filter'      => ['status' => [User::STATUS_ACTIVE, User::STATUS_INACTIVE]]
            ],
        ];
    }

    /**
     * Prediction bet okup.
     *
     * @return PredictionBet|null the saved model or null if saving fails
     * @throws Exception
     */
    public function predictionBetNeOkup()
    {
        if ($this->validate()) {
            $userBet = PredictionBet::findOne(['username' => Yii::$app->user->identity->username]);
            if (!$userBet) {
                $prediction = Prediction::find()->one();

                if ($prediction->status === Prediction::STATUS_ACTIVE) {
                    $userBet = new PredictionBet();
                    $userBet->prediction_type = PredictionBet::TYPE_NE_OKUP;
                    $userBet->username = Yii::$app->user->identity->username;
                    $userBet->points = $this->points;

                    $user = User::findOne(['username' => Yii::$app->user->identity->username]);
                    $user->points = $user->points - $this->points;
                    $user->save();

                    $prediction->points_ne_okup = $prediction->points_ne_okup + $this->points;
                    
                    $totalPoints = $prediction->points_okup + $prediction->points_ne_okup;
                    $prediction->percent_okup = ($prediction->points_okup / $totalPoints) * 100;
                    $prediction->percent_ne_okup = ($prediction->points_ne_okup / $totalPoints) * 100;

                    $probabilityOkup = $prediction->percent_okup / 100;
                    $probabilityNeOkup = $prediction->percent_ne_okup / 100;
                    if ($probabilityOkup != 0) {
                        $prediction->kf_okup = 1 / $probabilityOkup;
                    }
                    $prediction->kf_ne_okup = 1 / $probabilityNeOkup;

                    $prediction->save();

                    $userBet->save();
                }

                return true;
            }

            return true;
        }

        return null;
    }
}
