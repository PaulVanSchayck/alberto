<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class EightCell extends ActiveRecord {

    public static function tableName()
    {
        return 'eightcell';
    }

    public function getGene()
    {
        return $this->hasOne(Gene::className(), ['agi' => 'gene_agi']);
    }
}