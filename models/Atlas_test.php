<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Atlas_test extends ActiveRecord {

    public $experiment = 'atlas_test';

    public static function tableName()
    {
        return 'intact';
    }

    /**
     * @param $columns
     * @return array
     */
    public static function buildRelativeFields($columns)
    {
        $fields = [];

        foreach ( $columns as $column ) {
            if ( $column['type'] == 'abs' ) {
                $fields[] = $column['field'] . '_rel';
            }
        }

        return $fields;
    }

    public function attributes()
    {
        $attributes = parent::attributes();

        $columns = Yii::$app->params['experiments'][$this->experiment]['columns'];

        return array_merge($attributes, static::buildRelativeFields($columns));
    }

    public function getGene()
    {
        return $this->hasOne(Gene::className(), ['agi' => 'gene_agi']);
    }
}