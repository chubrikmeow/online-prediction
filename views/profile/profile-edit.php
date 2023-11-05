<?php

use common\models\upload\ProfileAvatarUploadForm;
use common\models\User;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\widgets\Menu;

/**
 * @var User                    $user
 * @var User                    $userForm
 * @var ProfileAvatarUploadForm $profileAvatarUploadForm
 */

$this->title = 'Editing your profile';

$success = Yii::$app->session->getFlash('success');
?>

<div class="fixed">
    <div class="row mb-4 margin-top">
        <div class="col-md-3 mb-3">
            <div class="white-block shadow-block">
                <?= Menu::widget(
                    [
                        'options'      => [
                            'class' => 'profile-menu',
                        ],
                        'encodeLabels' => false,
                        'items'        => [
                            [
                                'label' => '<i class="fa fa-table"></i> Home',
                                'url'   => ['/'],
                            ],
                            [
                                'label' => '<i class="fa fa-user"></i> Profile',
                                'url'   => ['profile/index'],
                            ],
                            [
                                'label' => '<i class="fa fa-edit"></i> Edit profile',
                                'url'   => ['profile/edit'],
                            ],
                        ],
                    ]
                ) ?>
            </div>
        </div>
        <div class="col-md-9 mb-3">
            <div class="white-block shadow-block margin-block-small ms-n15 me-n15">
            <h2>Editing your profile</h2>

            <?php if ($success) { ?>
                <div class="alert alert-success"><?= $success ?></div>
            <?php } ?>

            <?php $form = ActiveForm::begin(['id' => 'profile-edit']); ?>

            <div class="form-data pt-3">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <?= $form->field($userForm, 'username')->label(Yii::t('app', 'Username')); ?>
                    </div>
                    <div class="col-12 col-sm-6">
                        <?= $form->field($userForm, 'telegram')->label(Yii::t('app', 'Telegram (Username)')) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-6 order-1 order-md-0">
                        <label class="avatar-label">Avatar</label>
                        <div><?= $userForm->avatar ? Html::img(
                                $userForm->avatar->getUrl(),
                                ['class' => 'profile-avatar']
                            ) : '' ?></div>
                        <?= $fileInput = $form->field($profileAvatarUploadForm, 'file')
                            ->fileInput(['class' => 'form-control'])->label(false)
                            ->hint('The image size must not exceed 2 MB')
                        ?>
                    </div>
                </div>
            </div>

            <?= Html::submitButton(
                'Update info',
                ['class' => 'button btn-sign']
            ) ?>
            <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
