<?php

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var $model LoginForm
 */

$this->title = 'Sign In';
$this->params['breadcrumbs'][] = $this->title;

$messages = Yii::$app->session->getFlash('messages');

?>
<div class="fixed">
    <div class="white-block shadow-block site-signup border-block margin-block-small">
        <h1 class="text-center fw-bold h2 mb-4"><?= Html::encode($this->title) ?></h1>

        <div class="form-data">
            <?php if (!empty($messages)) { ?>
                <div class="alert alert-success"><?= $messages[0] ?></div>
            <?php } ?>
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
            <?= $form->errorSummary(
                $model,
                [
                    'header' => '<div class="alert alert-danger alert-dismissible">',
                    'footer' => '</div>'
                ]
            ) ?>
            <?= $form->field($model, 'username')->label(Yii::t('app', 'Username')) ?>
            <?= $form->field($model, 'password')->passwordInput()->label(Yii::t('app', 'Password')) ?>
            <?= $form->field($model, 'rememberMe')->checkbox(
                ['template' => '{input}{beginLabel}{labelTitle}{endLabel}{hint}']
            )->label(Yii::t('app', 'Remember me')) ?>
            <div class="form-group">
                <?= Html::submitButton(
                    'Sign In',
                    ['class' => 'button btn-sign', 'name' => 'sign-in-button']
                ) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
                    
        <div class="text-center">Don't have an account?</div>
        <a href="<?= Url::to(['auth/sign-up']) ?>" class="btn-sign-in"><strong>Sign Up</strong></a>

        <a href="<?= Url::to(['/']) ?>" class="btn-sign-in back"><strong>Go back to home</strong></a>
    </div>
</div>
