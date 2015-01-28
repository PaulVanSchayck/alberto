<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class q0990 extends ActiveRecord {

    public static function tableName()
    {
        return 'q0990';
    }

    public function getGene()
    {
        return $this->hasOne(Gene::className(), ['agi' => 'gene_agi']);
    }
}