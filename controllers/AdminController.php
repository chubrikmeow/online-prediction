<?php

namespace app\controllers;

use app\models\Prediction;
use app\models\PredictionBet;
use app\models\User;
use app\models\ban\BanForm;
use app\models\ban\UnbanForm;
use Yii;
use yii\web\Controller;

/**
 * Admin controller
 */
class AdminController extends Controller
{

    public function actionIndex()
    {
        $user = Yii::$app->user->identity;

        if (!$user || $user->role != User::ROLE_ADMIN) {
            return $this->render('/site/error', ['name' => 'Not Found (#404)', 'message' => 'Page not found.']);
        }

        $prediction = Prediction::find()->one();

        return $this->render('index', compact('user', 'prediction'));
    }

    /**
     * Start prediction.
     *
     * @return string
     */
    public function actionStartPrediction()
    {
        $user = Yii::$app->user->identity;

        if (!$user || $user->role != User::ROLE_ADMIN) {
            return $this->render('/site/error', ['name' => 'Not Found (#404)', 'message' => 'Page not found.']);
        }

        $prediction = Prediction::find()->one();

        $prediction->status = Prediction::STATUS_ACTIVE;
        $prediction->save();

        return $this->redirect('/admin/index/');
    }

    /**
     * End prediction.
     *
     * @return string
     */
    public function actionEndPrediction()
    {
        $user = Yii::$app->user->identity;

        if (!$user || $user->role != User::ROLE_ADMIN) {
            return $this->render('/site/error', ['name' => 'Not Found (#404)', 'message' => 'Page not found.']);
        }
        
        $prediction = Prediction::find()->one();

        $prediction->status = Prediction::STATUS_INACTIVE;
        $prediction->save();

        return $this->redirect('/admin/index/');
    }

    /**
     * Delete prediction.
     *
     * @return string
     */
    public function actionDeletePrediction()
    {
        $user = Yii::$app->user->identity;

        if (!$user || $user->role != User::ROLE_ADMIN) {
            return $this->render('/site/error', ['name' => 'Not Found (#404)', 'message' => 'Page not found.']);
        }
        
        $prediction = Prediction::find()->one();

        $predictionBets = PredictionBet::find()->all();

        if ($predictionBets) {
            foreach ($predictionBets as $predictionBet) {
                $user = User::findOne(['username' => $predictionBet->username]);
                $user->points = $user->points + $predictionBet->points;
                $user->save();
            }
        }

        $tableName = Yii::$app->db->quoteTableName('prediction_bet');
        $command = Yii::$app->db->createCommand("DELETE FROM $tableName");
        $command->execute();

        $prediction->status = Prediction::STATUS_DELETED;
        $prediction->points_okup = 0;
        $prediction->points_ne_okup = 0;
        $prediction->percent_okup = 0;
        $prediction->percent_ne_okup = 0;
        $prediction->kf_okup = 0.00;
        $prediction->kf_ne_okup = 0.00;
        $prediction->save();

        return $this->redirect('/admin/index/');
    }

    public function actionCalculateOkup()
    {
        $user = Yii::$app->user->identity;

        if (!$user || $user->role != User::ROLE_ADMIN) {
            return $this->render('/site/error', ['name' => 'Not Found (#404)', 'message' => 'Page not found.']);
        }

        $prediction = Prediction::find()->one();

        $predictionBets = PredictionBet::find()->where(['prediction_type' => PredictionBet::TYPE_OKUP])->all();

        if ($predictionBets) {
            foreach ($predictionBets as $predictionBet) {
                $user = User::findOne(['username' => $predictionBet->username]);
                $calculatePoints = $predictionBet->points * $prediction->kf_okup;
                $calculatePointsInt = (int) $calculatePoints;
                
                $user->points = $user->points +  $calculatePointsInt;
                $user->save();
            }
        }

        $tableName = Yii::$app->db->quoteTableName('prediction_bet');
        $command = Yii::$app->db->createCommand("DELETE FROM $tableName");
        $command->execute();

        $prediction->status = Prediction::STATUS_CALCULATE;
        $prediction->points_okup = 0;
        $prediction->points_ne_okup = 0;
        $prediction->percent_okup = 0;
        $prediction->percent_ne_okup = 0;
        $prediction->kf_okup = 0.00;
        $prediction->kf_ne_okup = 0.00;
        $prediction->save();
        
        return $this->redirect('/admin/index/');
    }

    public function actionCalculateNeOkup()
    {
        $user = Yii::$app->user->identity;

        if (!$user || $user->role != User::ROLE_ADMIN) {
            return $this->render('/site/error', ['name' => 'Not Found (#404)', 'message' => 'Page not found.']);
        }

        $prediction = Prediction::find()->one();

        $predictionBets = PredictionBet::find()->where(['prediction_type' => PredictionBet::TYPE_NE_OKUP])->all();
        
        if ($predictionBets) {
            foreach ($predictionBets as $predictionBet) {
                $user = User::findOne(['username' => $predictionBet->username]);
                $calculatePoints = $predictionBet->points * $prediction->kf_ne_okup;
                $calculatePointsInt = (int) $calculatePoints;
                
                $user->points = $user->points +  $calculatePointsInt;
                $user->save();
            }
        }

        $tableName = Yii::$app->db->quoteTableName('prediction_bet');
        $command = Yii::$app->db->createCommand("DELETE FROM $tableName");
        $command->execute();

        $prediction->status = Prediction::STATUS_CALCULATE;
        $prediction->points_okup = 0;
        $prediction->points_ne_okup = 0;
        $prediction->percent_okup = 0;
        $prediction->percent_ne_okup = 0;
        $prediction->kf_okup = 0.00;
        $prediction->kf_ne_okup = 0.00;
        $prediction->save();

        return $this->redirect('/admin/index/');
    }

    public function actionResetPoints()
    {
        $user = Yii::$app->user->identity;

        if (!$user || $user->role != User::ROLE_ADMIN) {
            return $this->render('/site/error', ['name' => 'Not Found (#404)', 'message' => 'Page not found.']);
        }

        return $this->render('reset-points', compact('user'));
    }

    public function actionReset()
    {
        $user = Yii::$app->user->identity;

        if (!$user || $user->role != User::ROLE_ADMIN) {
            return $this->render('/site/error', ['name' => 'Not Found (#404)', 'message' => 'Page not found.']);
        }

        $usersReset = User::find()->where(['status' => User::STATUS_ACTIVE, 'role' => 'user'])->andWhere(['!=', 'points', 50000])->all();
        
        if ($usersReset) {
            foreach ($usersReset as $userReset) {
                $userReset->points = 50000;
                $userReset->save();
            }
        }

        return $this->redirect('/');
    }

    public function actionBanList()
    {
        $user = Yii::$app->user->identity;

        if (!$user || $user->role != User::ROLE_ADMIN) {
            return $this->render('/site/error', ['name' => 'Not Found (#404)', 'message' => 'Page not found.']);
        }

        $modelBan = new BanForm();
        if ($modelBan->load(Yii::$app->request->post()) && $modelBan->ban()) {
            return $this->redirect('/admin/ban-list/');
        }

        $modelUnban = new UnbanForm();
        if ($modelUnban->load(Yii::$app->request->post()) && $modelUnban->unban()) {
            return $this->redirect('/admin/ban-list/');
        }

        $usersBanned = User::find()->where(['status' => User::STATUS_INACTIVE])->all();

        return $this->render('ban-list', compact('user', 'modelBan', 'modelUnban', 'usersBanned'));
    }

    public function actionWinner()
    {
        $user = Yii::$app->user->identity;

        if (!$user || $user->role != User::ROLE_ADMIN) {
            return $this->render('/site/error', ['name' => 'Not Found (#404)', 'message' => 'Page not found.']);
        }

        $winner = User::find()->where(['status' => User::STATUS_ACTIVE, 'role' => 'user'])->orderBy(['points' => SORT_DESC])->one();

        return $this->render('winner', compact('user', 'winner'));
    }

    public function actionSkip()
    {
        $user = Yii::$app->user->identity;

        if (!$user || $user->role != User::ROLE_ADMIN) {
            return $this->render('/site/error', ['name' => 'Not Found (#404)', 'message' => 'Page not found.']);
        }

        $winner = User::find()->where(['status' => User::STATUS_ACTIVE, 'role' => 'user'])->orderBy(['points' => SORT_DESC])->one();
        
        $winner->points = 0;
        $winner->save();

        return $this->redirect('/admin/winner/');
    }
}
