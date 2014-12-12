<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class MpProper extends ActiveRecord {

    public static function tableName()
    {
        return 'mpproper';
    }

    public function getGene()
    {
        return $this->hasOne(Gene::className(), ['agi' => 'gene_agi']);
    }
}