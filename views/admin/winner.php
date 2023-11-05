<?php

use app\models\User;
use yii\helpers\Html;
use yii\web\View;
use yii\web\JsExpression;

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
                        <h2>Winner 🎉</h2>
                        <?php if ($winner) { ?>
                            <?php if ($winner->avatar_id) { ?>
                                <img src="<?= $winner->avatar->getUrl() ?>" class="winner-avatar" alt="winner avatar">
                            <?php } else { ?>
                                <img src="/img/no-avatar.jpg" class="winner-avatar" alt="no avatar">
                            <?php } ?>
                            <div class="winner-username">Username: <strong><?= $winner->username ?></strong></div>
                            <div class="winner-telegram">Telegram: <strong><?= $winner->telegram ?></strong></div>
                            <?php if ($winner->role === User::ROLE_USER) { ?>
                                <div class="winner-points">Points: <strong><?= $winner->points ?></strong></div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <div class="white-block shadow-block margin-block-small ms-n15 me-n15 mt-4">
                <div class="row">
                    <div class="col-12 text-center">
                        <div class="skip-title">
                            <div class="skip-container">
                                If the winning user is not subscribed to the telegram, has a left telegram, or some other reason, click <strong>Skip</strong>, to choose the next winner
                            </div>
                        </div>
                        <div class="btn-grp pt-2">
                            <?= Html::button('Skip', ['id' => 'skip', 'class' => 'button']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

$this->registerJs(
    new JsExpression('
        $(document).on("click", "#skip", function(){
            $.ajax({
                url: "' . \yii\helpers\Url::to(["admin/skip"]) . '",
                type: "POST",
            });
        });
    '), View::POS_READY
);

?>
