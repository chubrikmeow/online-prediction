<?php

namespace app\controllers;

use app\models\Prediction;
use app\models\PredictionBet;
use app\models\prediction\PredictionBetOkupForm;
use app\models\prediction\PredictionBetNeOkupForm;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $users = User::find()->where(['status' => User::STATUS_ACTIVE, 'role' => 'user'])->limit(10)->orderBy(['points' => SORT_DESC])->all();

        $prediction = Prediction::find()->one();

        $modelOkup = new PredictionBetOkupForm();
        if ($modelOkup->load(Yii::$app->request->post()) && $modelOkup->predictionBetOkup()) {
            return $this->redirect('/');
        }

        $modelNeOkup = new PredictionBetNeOkupForm();
        if ($modelNeOkup->load(Yii::$app->request->post()) && $modelNeOkup->predictionBetNeOkup()) {
            return $this->redirect('/');
        }

        $predictionBet = null;

        if (!Yii::$app->user->isGuest) {
            $predictionBet = PredictionBet::findOne(['username' => Yii::$app->user->identity->username]);
        }

        return $this->render('index', compact('users', 'prediction', 'modelOkup', 'modelNeOkup', 'predictionBet'));
    }

    /**
     * Displays members.
     *
     * @return string
     */
    public function actionMembers()
    {
        $this->layout = false;

        $users = User::find()->where(['status' => User::STATUS_ACTIVE, 'role' => 'user'])->limit(10)->orderBy(['points' => SORT_DESC])->all();

        return $this->render('main/members', compact('users'));
    }

    /**
     * Displays prediction.
     *
     * @return string
     */
    public function actionPrediction()
    {
        $this->layout = false;

        $prediction = Prediction::find()->one();

        $predictionBet = null;

        if (!Yii::$app->user->isGuest) {
            $predictionBet = PredictionBet::findOne(['username' => Yii::$app->user->identity->username]);
        }

        return $this->render('main/prediction', compact('prediction', 'predictionBet'));
    }
}
