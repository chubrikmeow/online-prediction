<?php

use app\models\User;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JqueryAsset;
use yii\web\View;

/** 
 * @var View $this 
 */

$this->title = 'Online Prediction';

?>

<div class="fixed">
    <div class="main-block white-block shadow-block">
        <h1>Online Prediction</h1>
        <div class="avatar-main">
            <?php if (Yii::$app->user->isGuest) { ?>
                <img src="/img/no-avatar.jpg" alt="no avatar">
            <?php } else { ?>
                <?php if (Yii::$app->user->identity->avatar_id) { ?>
                    <img src="<?= Yii::$app->user->identity->avatar->getUrl() ?>" alt="avatar main">
                <?php } else { ?>
                    <img src="/img/no-avatar.jpg" alt="no avatar">
                <?php } ?>
            <?php } ?>
        </div>
        <div class="btn-grp">
            <?php if (Yii::$app->user->isGuest) { ?>
                <a href="<?= Url::to(['auth/sign-up']) ?>" class="button">Sign Up</a>
                <a href="<?= Url::to(['auth/sign-in']) ?>" class="button">Sign In</a>
            <?php } else { ?>
                <a href="<?= Url::to(['profile/index']) ?>" class="button"><i class="fa fa-user"></i> <?= Yii::$app->user->identity->username ?></a>
                <?php if (Yii::$app->user->identity->role === User::ROLE_ADMIN) { ?>
                    <a href="<?= Url::to(['admin/index']) ?>" class="button">Admin panel</a>
                <?php } ?>
                <a href="<?= Url::to(['auth/logout']) ?>" class="button">Logout</a>
            <?php } ?>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-md-6 order-1 order-md-0">
            <?= $this->render('main/members', compact('users')) ?>
        </div>
        <div class="col-md-6 order-0 order-md-1">
            <div class="prediction-block white-block shadow-block">
                <?= $this->render('main/prediction', compact('prediction', 'predictionBet')) ?>
            </div>
        </div>
    </div>
</div>

<?php if (!Yii::$app->user->isGuest) { ?>
    <!-- Modal -->
    <div class="modal fade" id="predictionOkupModal" tabindex="-1" aria-labelledby="predictionOkupModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="predictionOkupModalLabel">Win</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="form-data">
                        <?php $form = ActiveForm::begin(['id' => 'form-okup', 'options' => ['autocomplete' => 'off']]); ?>
                        <?= $form->field($modelOkup, 'points')->label(Yii::t('app', 'Quantity')) ?>
                        <div class="form-group">
                            <?= Html::submitButton(
                                'Put',
                                ['class' => 'button btn-sign', 'name' => 'okup-button']
                            ) ?>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                    <div class="info">If you have enough points but get an error, refresh the page</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="predictionNeOkupModal" tabindex="-1" aria-labelledby="predictionNeOkupModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="predictionNeOkupModalLabel">Lose</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="form-data">
                        <?php $form = ActiveForm::begin(['id' => 'form-ne-okup', 'options' => ['autocomplete' => 'off']]); ?>
                        <?= $form->field($modelNeOkup, 'points')->label(Yii::t('app', 'Quantity')) ?>
                        <div class="form-group">
                            <?= Html::submitButton(
                                'Put',
                                ['class' => 'button btn-sign', 'name' => 'ne-okup-button']
                            ) ?>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                    <div class="info">If you have enough points but get an error, refresh the page</div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<?php $this->registerJsFile('/js/members.js', ['depends' => [JqueryAsset::class]]); ?>
<?php $this->registerJsFile('/js/prediction.js', ['depends' => [JqueryAsset::class]]); ?>
