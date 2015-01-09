<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Intact extends ActiveRecord {

    private $relativeGene;

    public static function tableName()
    {
        return 'intact';
    }

    public function getRelativeFields()
    {
        $intact = Yii::$app->params['experiments']['intact'];

        $fields = [];

        foreach ( $intact['columns'] as $column ) {
            if ( $column['type'] == 'abs' ) {
                $fields[] = $column['field'];
            }
        }

        return [];
    }

    public function setRelativeGene($gene)
    {
        $this->relativeGene = $gene;
    }

    public function getRelativeField($name)
    {
        return $this->$name;
    }

    public function __get($name)
    {
        if ( array_search($name, $this->getRelativeFields()) ) {
            return $this->getRelativeField($name);
        } else {
            return parent::__get($name);
        }
    }

    public function getGene()
    {
        return $this->hasOne(Gene::className(), ['agi' => 'gene_agi']);
    }
}