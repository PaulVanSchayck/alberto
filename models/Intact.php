<?php

namespace app\models;

use yii\db\ActiveRecord;

class Intact extends ActiveRecord {

    public static function tableName()
    {
        return 'intact';
    }

    /**
     * Here we can add extra fields to the model
     *
     * @return array
     */
    public function fields()
    {
        return array_merge(
            parent::fields(),
            ['gene']
        );
    }

    public function getGene()
    {
        return $this->hasOne(Gene::className(), ['agi' => 'gene_agi']);
    }
}