<?php

/** @var yii\web\View $this */
/** @var string $name */
/** @var string $message */
/** @var Exception $exception */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $name;
?>
<div class="fixed">
    <div class="site-error white-block shadow-block">
        <h1><?= Html::encode($this->title) ?></h1>
        <div class="alert alert-danger">
            <?= nl2br(Html::encode($message)) ?>
        </div>
        <p>The above error occurred while the web server was processing your request.</p>
        <p>Please contact us if you think this is a server error. Thank you.</p>

        <a href="<?= Url::to(['/']) ?>" class="btn-sign-in back"><strong>Go back to home</strong></a>
    </div>
</div>
