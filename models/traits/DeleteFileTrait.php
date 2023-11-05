<?php

namespace app\models\traits;

use app\models\Files;
use yii\db\StaleObjectException;

trait DeleteFileTrait
{
    /**
     * @param $changedAttributes
     * @param $fields
     *
     * @throws StaleObjectException
     */
    public function deleteFileAfterSave($changedAttributes, $fields): void
    {
        foreach ($fields as $field) {
            $this->{$field}; // throw an exception if the property is wrong
            if (!empty($changedAttributes[$field])) {
                $file = Files::find()->where(['id' => $changedAttributes[$field]])->one();
                if (!empty($file)) {
                    $file->delete();
                }
            }
        }
    }
}