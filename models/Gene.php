<?php

namespace app\models;

use yii\db\ActiveRecord;

class Gene extends ActiveRecord {

    public static function tableName()
    {
        return 'gene';
    }

}