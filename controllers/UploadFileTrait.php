<?php

namespace app\controllers;

use Yii;
use yii\helpers\Inflector;

trait UploadFileTrait
{

    protected function uploadFile($uploadForm, &$model, $field): void
    {
        $uploadForm->loadInstance();

        if ($uploadForm->validate() && $uploadForm->upload()) {
            $model->{$field . '_id'} = $uploadForm->id;
        } elseif (!empty(
            $model->{Inflector::variablize($field)}
            && !empty(Yii::$app->request->post(Inflector::variablize('delete_' . $field)))
        )
        ) {
            $model->{Inflector::variablize($field)}->delete();
        }
    }
}
