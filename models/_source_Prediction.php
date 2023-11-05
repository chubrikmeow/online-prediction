<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "prediction".
 *
 * @property int $id
 * @property int $status
 * @property int|null $points_okup
 * @property int|null $points_ne_okup
 * @property float|null $percent_okup
 * @property float|null $percent_ne_okup
 * @property float|null $kf_okup
 * @property float|null $kf_ne_okup
 *
 */
class _source_Prediction extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'prediction';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'required'],
            [['status', 'points_okup', 'points_ne_okup'], 'integer'],
            [['percent_okup', 'percent_ne_okup', 'kf_okup', 'kf_ne_okup'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status' => 'Status',
            'points_okup' => 'Points Okup',
            'points_ne_okup' => 'Points Ne Okup',
            'percent_okup' => 'Percent Okup',
            'percent_ne_okup' => 'Percent Ne Okup',
            'kf_okup' => 'Kf Okup',
            'kf_ne_okup' => 'Kf Ne Okup',
        ];
    }
}
