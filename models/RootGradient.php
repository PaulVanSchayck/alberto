<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class RootGradient extends ActiveRecord {

    public static function tableName()
    {
        return 'rootgradient';
    }

    public function getGene()
    {
        return $this->hasOne(Gene::className(), ['agi' => 'gene_agi']);
    }
}