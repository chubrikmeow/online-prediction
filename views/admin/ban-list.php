<?php

use app\models\User;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

/**
 * @var User $user
 */

$this->title = 'Admin Panel';

?>

<div class="fixed">
    <div class="row mb-4 margin-top">
        <div class="col-md-3 mb-3">
            <?= $this->render('admin-menu') ?>
        </div>
        <div class="col-md-9 mb-3">
            <div class="white-block shadow-block margin-block-small ms-n15 me-n15">
                <div class="row">
                    <div class="col-12 text-center">
                        <div class="btn-grp pb-2">
                            <button type="button" class="button" data-bs-toggle="modal" data-bs-target="#banModal">Ban</button>
                            <button type="button" class="button" data-bs-toggle="modal" data-bs-target="#unbanModal">Unban</button>
                        </div>
                        <div class="ban-list">
                            <div class="ban-list-title">Banned users</div>
                            <ol>
                                <?php foreach ($usersBanned as $userBanned) { ?>
                                    <li><?php if ($userBanned->avatar_id) { ?>
                                        <img src="<?= $userBanned->avatar->getUrl() ?>" alt="avatar">
                                    <?php } else { ?>
                                        <img src="/img/no-avatar.jpg" alt="no avatar">
                                    <?php } ?> <strong><?= $userBanned->username ?></strong></li>
                                <?php } ?>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="banModal" tabindex="-1" aria-labelledby="banModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="banModalLabel">Ban</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <div class="form-data">
                    <?php $form = ActiveForm::begin(['id' => 'form-okup', 'options' => ['autocomplete' => 'off']]); ?>
                    <?= $form->field($modelBan, 'username')->label(Yii::t('app', 'Username')) ?>
                    <div class="form-group">
                        <?= Html::submitButton(
                            'Бан',
                            ['class' => 'button btn-sign', 'name' => 'okup-button']
                        ) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="unbanModal" tabindex="-1" aria-labelledby="unbanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="unbanModalLabel">Unban</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <div class="form-data">
                    <?php $form = ActiveForm::begin(['id' => 'form-ne-okup', 'options' => ['autocomplete' => 'off']]); ?>
                    <?= $form->field($modelUnban, 'username')->label(Yii::t('app', 'Username')) ?>
                    <div class="form-group">
                        <?= Html::submitButton(
                            'Разбан',
                            ['class' => 'button btn-sign', 'name' => 'ne-okup-button']
                        ) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
