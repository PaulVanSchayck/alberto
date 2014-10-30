<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class Gene extends ActiveRecord {

    public $fc;

    public static function tableName()
    {
        return 'gene_old';
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
            ['fc','geneShort']
        );
    }

    /**
     * @return ActiveQuery the newly created [[ActiveQuery]] instance.
     */
    public static function findFc()
    {
        return static::find()->select(['*','ROUND(iqd15_lg / rps5a_lg,3) as fc']);
    }

    public function getGeneShort()
    {
        return substr($this->gene,0,10);
    }
}