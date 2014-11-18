<?php

namespace app\models;

use yii\db\ActiveRecord;

class Gene extends ActiveRecord {

    public static function tableName()
    {
        return 'gene';
    }

    /**
     * Here we can add extra fields to the model
     *
     * @return array
     */
    public function fields()
    {
        $fields = parent::fields();

        unset($fields['location']);

        return $fields;
    }
}