<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * GeneRequest is the model behind the requests of DataTables.
 * See https://datatables.net/manual/server-side for an explanation of these requests
 */
class GeneRequest extends Model {

    public $start;
    public $draw;
    public $length = 10;
    public $columns;
    public $order;

    /**
     * The form name is set to be empty, as the request is not placed in a a scope
     *
     * @return string empty
     */
    public function formName() {
        return '';
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['start'], 'required'],
            // TODO: improve length validation
            [['draw', 'length'], 'integer'],
            ['columns', 'validateColumns'],
            ['order', 'validateOrder']
        ];
    }

    public function getPaginationConfig() {
        return [
            'pageSize' => $this->length,
            'page' => $this->start,
            'draw' => $this->draw
        ];
    }

    /**
     * Validate the contents of the columns array
     *
     * @param $attribute
     * @internal param $params
     */
    public function validateColumns($attribute)
    {
        // TODO: improve this validator!
        if (!is_array($this->$attribute)) {
            $this->addError($attribute, "Columns is not specified as an array");
        }
    }

    /**
     * Validate the contents of the columns array
     *
     * @param $attribute
     * @internal param $params
     */
    public function validateOrder($attribute)
    {
        // TODO: improve this validator!
        if (!is_array($this->$attribute)) {
            $this->addError($attribute, "Order is not specified as an array");
        }

        foreach ( $this->$attribute as $order ) {
            if( ! array_key_exists($order['column'], $this->columns) ) {
                $this->addError($attribute, "Order has an unspecified column as order target");
            }
        }
    }

    /**
     * Builds the conditionals as being specified in the filters
     *
     * @return array
     */
    public function getFilter()
    {
        // Join all filters with AND
        $filter = ['and'];

        foreach( $this->columns as $column ) {
            if ( $column['name'] == 'range' && strstr($column['search']['value'], '-yadcf_delim-')) {
                $range = explode('-yadcf_delim-', $column['search']['value']);

                if ( is_numeric($range[0]) && is_numeric($range[1]) ) {
                    $filter[] = ['between', $column['data'], $range[0], $range[1] ];
                } else if( is_numeric($range[0]) ) {
                    $filter[] = ['>=', $column['data'], $range[0] ];
                } else if( is_numeric($range[1]) ) {
                    $filter[] = ['<=', $column['data'], $range[1]];
                }
            } else {
                $filter[] = ['like', $column['data'], $column['search']['value']];
            }
        }

        return $filter;
    }

    public function getColumns()
    {
        $columns = [];

        foreach( $this->columns as $column ) {
            if( $column['data'] != 'gene.geneShort' ) {
                $columns[] = $column['data'];
            }
        }

        return $columns;
    }



    public function getOrder()
    {
        $order = [];

        foreach( $this->order as $o ) {
            $columnName = $this->columns[$o['column']]['data'];

            if( $o['dir'] == 'asc' ) {
                $dir = SORT_ASC;
            } else {
                $dir = SORT_DESC;
            }

            $order[$columnName] = $dir;
        }

        return $order;
    }
}