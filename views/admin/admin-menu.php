<?php

use yii\widgets\Menu;

?>

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
                    'label' => '<i class="fa fa-chart-bar"></i> Prediction',
                    'url'   => ['admin/index'],
                ],
                [
                    'label' => '<i class="fa fa-trophy"></i> Winner',
                    'url'   => ['admin/winner'],
                ],
                [
                    'label' => '<i class="fa fa-sync"></i> Reset points',
                    'url'   => ['admin/reset-points'],
                ],
                [
                    'label' => '<i class="fa fa-file"></i> Ban list',
                    'url'   => ['admin/ban-list'],
                ],
            ],
        ]
    ) ?>
</div>
