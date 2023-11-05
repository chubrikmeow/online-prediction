<?php

namespace app\models;

class Prediction extends _source_Prediction
{
    public const STATUS_INACTIVE  = 0;
    public const STATUS_ACTIVE    = 1;
    public const STATUS_CALCULATE = 2;
    public const STATUS_DELETED   = 3;
}
