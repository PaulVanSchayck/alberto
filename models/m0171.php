<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class m0171 extends ActiveRecord {

    public static function tableName()
    {
        return 'm0171';
    }

    public function getGene()
    {
        return $this->hasOne(Gene::className(), ['agi' => 'gene_agi']);
    }
}