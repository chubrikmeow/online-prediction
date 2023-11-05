<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property int $prediction_type
 * @property int|null $points
 *
 */
class _source_PredictionBet extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'prediction_bet';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['prediction_type', 'username', 'points'], 'required'],
            [['prediction_type', 'points'], 'integer'],
            [['username'], 'string', 'max' => 32],
            [['username'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'prediction_type' => 'Status',
            'username' => 'Username',
            'points' => 'Points',
        ];
    }
}
