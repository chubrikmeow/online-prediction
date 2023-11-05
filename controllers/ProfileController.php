<?php

namespace app\controllers;

use app\controllers\UploadFileTrait;
use app\models\upload\ProfileAvatarUploadForm;
use app\models\form\UserForm;
use Yii;
use yii\web\Controller;

/**
 * Profile controller
 */
class ProfileController extends Controller
{
    use UploadFileTrait;

    public function actionIndex()
    {
        $user = Yii::$app->user->identity;

        if (!$user) {
            return $this->render('/site/error', ['name' => 'Not Found (#404)', 'message' => 'Page not found.']);
        }

        return $this->render('index', compact('user'));
    }

    public function actionEdit()
    {
        $user = Yii::$app->user->identity;

        if (!$user) {
            return $this->render('/site/error', ['name' => 'Not Found (#404)', 'message' => 'Page not found.']);
        }

        $userForm = UserForm::find()->where(['id' => $user->getId()])->one();

        $profileAvatarUploadForm = new ProfileAvatarUploadForm();

        if (Yii::$app->request->isPost && $userForm->load(Yii::$app->request->post()) && $userForm->saveData()) {
            $this->uploadFile($profileAvatarUploadForm, $userForm, 'avatar');
            $userForm->save();
            Yii::$app->session->setFlash('success', 'Data saved');
            return $this->redirect(['profile/edit']);
        }

        return $this->render('profile-edit', compact('userForm', 'profileAvatarUploadForm'));
    }
}
