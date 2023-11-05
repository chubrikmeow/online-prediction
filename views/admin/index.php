<?php

use app\models\Prediction;
use app\models\User;
use yii\helpers\Html;
use yii\web\View;
use yii\web\JsExpression;
use yii\web\JqueryAsset;

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
                        <div class="btn-grp">
                            <?= Html::button('Start prediction', ['id' => 'start-prediction', 'class' => 'button']) ?>
                            <?= Html::button('End prediction', ['id' => 'end-prediction', 'class' => 'button']) ?>
                        </div>
                        <?= $this->render('@app/views/site/main/prediction', compact('prediction')) ?>
                        <?php if ($prediction->status === Prediction::STATUS_INACTIVE) { ?>
                            <div class="bet pt-2 pb-4">
                                <div class="bet-title">Calculate prediction</div>
                                <div class="btn-grp">
                                    <?= Html::button('Win', ['id' => 'calculate-okup', 'class' => 'button']) ?>
                                    <?= Html::button('Lose', ['id' => 'calculate-ne-okup', 'class' => 'button']) ?>
                                </div>
                            </div>
                            <div class="bet pt-2">
                                <div class="bet-title">Delete the current prediction and return everyones points</div>
                                <div class="btn-grp">
                                <?= Html::button('Delete prediction', ['id' => 'delete-prediction', 'class' => 'button']) ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

$this->registerJs(
    new JsExpression('
        $(document).on("click", "#start-prediction", function(){
            $.ajax({
                url: "' . \yii\helpers\Url::to(["admin/start-prediction"]) . '",
                type: "POST",
            });
        });
    '), View::POS_READY
);

$this->registerJs(
    new JsExpression('
        $(document).on("click", "#end-prediction", function(){
            $.ajax({
                url: "' . \yii\helpers\Url::to(["admin/end-prediction"]) . '",
                type: "POST",
            });
        });
    '), View::POS_READY
);

$this->registerJs(
    new JsExpression('
        $(document).on("click", "#calculate-okup", function(){
            $.ajax({
                url: "' . \yii\helpers\Url::to(["admin/calculate-okup"]) . '",
                type: "POST",
            });
        });
    '), View::POS_READY
);

$this->registerJs(
    new JsExpression('
        $(document).on("click", "#calculate-ne-okup", function(){
            $.ajax({
                url: "' . \yii\helpers\Url::to(["admin/calculate-ne-okup"]) . '",
                type: "POST",
            });
        });
    '), View::POS_READY
);

$this->registerJs(
    new JsExpression('
        $(document).on("click", "#delete-prediction", function(){
            $.ajax({
                url: "' . \yii\helpers\Url::to(["admin/delete-prediction"]) . '",
                type: "POST",
            });
        });
    '), View::POS_READY
);

$this->registerJsFile('/js/prediction.js', ['depends' => [JqueryAsset::class]]);

?>
