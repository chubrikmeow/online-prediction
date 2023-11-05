<?php

use app\models\User;
use yii\helpers\Url;
use yii\widgets\Menu;

/**
 * @var User $user
 */

$this->title = trim($user->username);

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
                <div class="row">
                    <div class="col-12 text-center">
                        <h2><?= $user->username ?></h2>
                        <?php if ($user->avatar_id) { ?>
                            <img src="<?= $user->avatar->getUrl() ?>" class="profile-avatar-main" alt="profile avatar">
                        <?php } else { ?>
                            <img src="/img/no-avatar.jpg" class="profile-avatar-main" alt="no avatar">
                        <?php } ?>
                        <?php if ($user->role === User::ROLE_USER) { ?>
                            <div class="profile-points">Points: <strong><?= $user->points ?></strong></div>
                        <?php } else if ($user->role=== User::ROLE_ADMIN) { ?>
                            <div class="mt-4"><a href="<?= Url::to(['admin/index']) ?>" class="button">Admin panel</a></div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
