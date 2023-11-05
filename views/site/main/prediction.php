<?php

use app\models\Prediction;
use app\models\PredictionBet;
use app\models\User;
use app\models\prediction\PredictionBetOkupForm;
use app\models\prediction\PredictionBetNeOkupForm;
use yii\helpers\Url;

/** 
 * @var Prediction $prediction
 * @var PredictionBet $predictionBet
 * @var PredictionBetOkupForm $modelOkup
 * @var PredictionBetNeOkupForm $modelNeOkup
 */

?>

<div id="prediction">
    <?php if (!Yii::$app->user->isGuest) { ?>
        <?php if (Yii::$app->user->identity->role === User::ROLE_USER) { ?>
            <div class="points"><strong>Your points: <?= Yii::$app->user->identity->points ?></strong></div>
        <?php } ?>
    <?php } ?>
    <?php if ($prediction->status === Prediction::STATUS_ACTIVE) { ?>
        <div class="prediction-title">Prediction open!</div>
    <?php } else if ($prediction->status === Prediction::STATUS_INACTIVE) { ?>
        <div class="prediction-title">Prediction closed!</div>
    <?php } else if ($prediction->status === Prediction::STATUS_CALCULATE) { ?>
        <div class="prediction-title">Prediction calculated!</div>
    <?php } else if ($prediction->status === Prediction::STATUS_DELETED) { ?>
        <div class="prediction-title">Prediction removed!</div>
    <?php } ?>
    <div class="row text-center pt-3 pb-3">
        <div class="col-md-6">
            <div class="okup-title">% for win</div>
            <div class="okup-value"><?= $prediction->percent_okup ?>%</div>
            <div class="okup-title">Total points for win</div>
            <div class="okup-value"><?= $prediction->points_okup ?></div>
            <div class="okup-title">Win coefficient</div>
            <div class="okup-value"><?= $prediction->kf_okup ?></div>
        </div>
        <div class="col-md-6">
            <div class="okup-title">% for lose</div>
            <div class="okup-value"><?= $prediction->percent_ne_okup ?>%</div>
            <div class="okup-title">Total points for lose</div>
            <div class="okup-value"><?= $prediction->points_ne_okup ?></div>
            <div class="okup-title">Lose coefficient</div>
            <div class="okup-value"><?= $prediction->kf_ne_okup ?></div>
        </div>
    </div>
    <?php if ($prediction->status === Prediction::STATUS_ACTIVE) { ?>
        <?php if (Yii::$app->user->isGuest) { ?>
            <div class="prediction-guest pt-2">
                <a href="<?= Url::to(['auth/sign-in']) ?>"><strong>Sign in</strong></a> to your account or 
                <a href="<?= Url::to(['auth/sign-up']) ?>"><strong>sign up</strong></a>, to make a prediction
            </div>
        <?php } else { ?>
            <?php if (Yii::$app->user->identity->role === User::ROLE_USER) { ?>
                <div class="bet pt-2">
                    <?php if ($predictionBet) { ?>
                        <div class="bet-title">
                            You put <?= $predictionBet->points ?> points for
                            <?php if ($predictionBet->prediction_type === PredictionBet::TYPE_OKUP) { ?>
                                win
                            <?php } else if ($predictionBet->prediction_type === PredictionBet::TYPE_NE_OKUP) { ?>
                                lose
                            <?php } ?>
                        </div>
                    <?php } else { ?>
                        <div class="bet-title">Put points</div>
                            <div class="btn-grp">
                                <button type="button" class="button" data-bs-toggle="modal" data-bs-target="#predictionOkupModal">Win</button>
                                <button type="button" class="button" data-bs-toggle="modal" data-bs-target="#predictionNeOkupModal">Lose</button>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
        <?php } ?>
    <?php } else if ($prediction->status === Prediction::STATUS_INACTIVE) { ?>
        <?php if (Yii::$app->user->isGuest) { ?>
            <div class="prediction-guest pt-2">
                <a href="<?= Url::to(['auth/sign-in']) ?>"><strong>Sign in</strong></a> to your account or 
                <a href="<?= Url::to(['auth/sign-up']) ?>"><strong>sign up</strong></a>, to make a prediction
            </div>
        <?php } else { ?>
            <?php if (Yii::$app->user->identity->role === User::ROLE_USER) { ?>
                <?php if ($predictionBet) { ?>
                    <div class="bet pt-2">
                        <div class="bet-title">
                            You put <?= $predictionBet->points ?> points for
                            <?php if ($predictionBet->prediction_type === PredictionBet::TYPE_OKUP) { ?>
                                win
                            <?php } else if ($predictionBet->prediction_type === PredictionBet::TYPE_NE_OKUP) { ?>
                                lose
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
        <?php } ?>
    <?php } ?>
</div>
