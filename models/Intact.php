<?php

namespace app\models;

use yii\db\ActiveRecord;

class Intact extends ActiveRecord {

    public static function tableName()
    {
        return 'intact';
    }

    public function getGene()
    {
        return $this->hasOne(Gene::className(), ['agi' => 'gene_agi']);
    }
}