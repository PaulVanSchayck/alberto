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
    public $includeAnnotations;

    private static $prefixes = ['gene'];

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
            [['start','length','columns','order'], 'required'],
            ['length', 'integer', 'max' => 2000],
            ['draw', 'integer'],
            ['columns', 'validateColumns'],
            ['order', 'validateOrder'],
            ['includeAnnotations', 'boolean', 'trueValue' => 'true', 'falseValue' => 'false', 'strict' => true],
        ];
    }

    public function getPaginationConfig() {
        return [
            'pageSize' => $this->length,
            'offset' => $this->start,
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
        $columns = $this->$attribute;

        if (!is_array($columns)) {
            $this->addError($attribute, "Columns is not specified as an array");
            return;
        }

        foreach ( $columns as $i => $column ) {

            if ( !isset($column['data']) ) {
                $this->addError($attribute, "Column $i has no data attribute");
                break;
            }

            $name = $column['data'];

            // The column name may be prefixed with a table, allow for this by extracting the prefix
            if (($pos = strrpos($name, '.')) !== false) {
                $prefix = substr($name, 0, $pos);
                $name = substr($name, $pos + 1);

                if (! in_array($prefix, self::$prefixes)) {
                    $this->addError($attribute, "Unknown prefix `$prefix`");
                    break;
                }
            } else {
                $prefix = 'intact';
            }

            // Check which columns are available
            $class = 'app\\models\\' . ucwords($prefix);
            $columns =  $class::getTableSchema()->columnNames;

            if ( ! in_array($name,$columns) ) {
                $this->addError($attribute, "Column " . $column['data'] . " is not a valid column");
                break;
            };
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
        if (!is_array($this->$attribute)) {
            $this->addError($attribute, "Order is not specified as an array");
            return;
        }

        foreach ( $this->$attribute as $order ) {
            if( ! array_key_exists($order['column'], $this->columns) ) {
                $this->addError($attribute, "Order has an unspecified column as order target");
                break;
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
            if ( strpos($column['search']['value'], '-yadcf_delim-') !== false ) {
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
            $columns[] = $column['data'];
        }

        return $columns;
    }

    public function getVisibleColumns()
    {
        $columns = [];

        foreach( $this->columns as $column ) {
            if ( $column['visible'] == 'true' ) {
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