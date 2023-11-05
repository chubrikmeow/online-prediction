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
                        <div class="reset-title">Reset all users points to 50,000</div>
                        <div class="btn-grp pt-2">
                            <?= Html::button('Reset', ['id' => 'reset', 'class' => 'button']) ?>
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
        $(document).on("click", "#reset", function(){
            $.ajax({
                url: "' . \yii\helpers\Url::to(["admin/reset"]) . '",
                type: "POST",
            });
        });
    '), View::POS_READY
);

?>
