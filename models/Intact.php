<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Intact extends ActiveRecord {

    public static function tableName()
    {
        return 'intact';
    }

    public function setRelativeFields()
    {
        $intact = Yii::$app->params['experiments']['intact'];

        foreach ( $intact['columns'] as $column ) {
            if ( $column['type'] == 'abs' ) {

            }
        }

        $fields = [];

        return $fields;
    }

    public function getGene()
    {
        return $this->hasOne(Gene::className(), ['agi' => 'gene_agi']);
    }
}