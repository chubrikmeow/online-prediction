<?php

use common\models\auth\SignupForm;
use himiklab\yii2\recaptcha\ReCaptcha2;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var SignupForm $model
 */

$this->title = 'Sign Up';
$this->params['breadcrumbs'][] = $this->title;

$messages = Yii::$app->session->getFlash('messages');

?>

<div class="fixed">
    <div class="white-block shadow-block site-signup border-block margin-block-small">
        <h1 class="text-center fw-bold h2 mb-4"><?= Html::encode($this->title) ?></h1>

        <div class="form-data">
            <?php if (!empty($messages)) { ?>
                <div class="alert alert-success"><?= $messages[0] ?></div>
            <?php } else { ?>

            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
            <?= $form->field($model, 'username')->label(Yii::t('app', 'Username')) ?>
            <?= $form->field($model, 'telegram')->label(Yii::t('app', 'Telegram (Username)')) ?>
            <?= $form->field($model, 'password')->passwordInput()->label(Yii::t('app', 'Password')) ?>
            <?= $form->field($model, 'password_repeat')->passwordInput()->label(Yii::t('app', 'Repeat password')) ?>
            <?= $form->field($model, 'reCaptcha')->widget(ReCaptcha2::class)->label('') ?>
            <div class="form-group">
                <?= Html::submitButton(
                    'Sign Up',
                    ['class' => 'button btn-sign', 'name' => 'signup-button']
                ) ?>
            </div>
            <?php ActiveForm::end(); ?>
            <?php } ?>
        </div>
                        
        <div class="text-center">Already have an account?</div>
        <a href="<?= Url::to(['auth/sign-in']) ?>" class="btn-sign-in"><strong>Sign In</strong></a>

        <a href="<?= Url::to(['/']) ?>" class="btn-sign-in back"><strong>Go back to home</strong></a>
    </div>
</div>
