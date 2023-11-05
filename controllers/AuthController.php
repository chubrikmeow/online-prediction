<?php

namespace app\controllers;

use app\models\auth\LoginForm;
use app\models\auth\SignupForm;
use Yii;
use yii\base\Exception;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;

/**
 * Auth controller
 */
class AuthController extends Controller
{
    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionSignIn()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['/']);
        }
        if (!empty(Yii::$app->request->get('returnUrl'))) {
            Yii::$app->user->returnUrl = Yii::$app->request->get('returnUrl');
        } else {
            Yii::$app->user->returnUrl = Url::to(['/']);
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $returnUrl = Yii::$app->user->returnUrl;
            Yii::$app->user->returnUrl = Url::to('/');
            return $this->redirect($returnUrl);
        }

        return $this->render('sign-in', ['model' => $model]);
    }

    /**
     * Signs user up.
     *
     * @return string|Response
     * @return mixed
     * @throws Exception
     *
     */
    public function actionSignUp()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect('/');
        }
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $user = $model->signup()) {
            Yii::$app->session->addFlash('messages', 'Thank you for registering! You can now sign in into your account!');
        }
        return $this->render('sign-up', ['model' => $model]);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
