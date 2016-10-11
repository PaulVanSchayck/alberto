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
    public $length;
    public $columns;
    public $order;
    public $includeAnnotations;
    public $relativeGene;

    private static $prefixes = ['gene'];
    private $tableModel;

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
            ['length', 'integer', 'max' => 30000],
            ['draw', 'integer'],
            ['columns', 'validateColumns'],
            ['order', 'validateOrder'],
            ['includeAnnotations', 'boolean'],
            ['relativeGene', 'string']
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
                $prefix = $this->tableModel;
            }

            // Check which columns (real and virtual, hence attributes()) are available
            $class = 'app\\models\\' . ucwords($prefix);
            $model = new $class;
            $columnNames = $model->attributes();

            if ( ! in_array($name,$columnNames) ) {
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

        // Check which columns are available
        $class = 'app\\models\\' . ucwords($this->tableModel);
        $inTable = array_keys($class::getTableSchema()->columns);

        foreach( $this->columns as $column ) {
            if ( in_array($column['data'], $inTable) ) {
                $columns[] = $column['data'];
            }
        }

        return $columns;
    }

    public function getVisibleColumns()
    {
        $columns = [];

        // Filter annotations
        if ( $this->includeAnnotations ) {
            $columns[] = 'gene.gene';
            $columns[] = 'gene.annotation';
        }

        // Check which columns are available
        $class = 'app\\models\\' . ucwords($this->tableModel);
        $inTable = array_keys($class::getTableSchema()->columns);

        foreach( $this->columns as $column ) {
            if ( $column['visible'] == 'true'  && in_array($column['data'], $inTable) ) {
                $columns[] = $column['data'];
            }
        }

        return $columns;
    }

    /**
     * @param $columns
     * @param $model \yii\db\ActiveRecord
     * @return array
     */
    public function getRelativeFields($columns, $model)
    {
        $baseGene = $model::findOne(['gene_agi' => $this->relativeGene]);

        $fields = [];


        foreach ( $columns as $column ) {
            if ( $column['type'] == 'abs' ) {

                if ( $baseGene == null ){
                    $base = 0;
                } else {
                    $base = $baseGene->getAttribute($column['field']);
                }

                $fields[$column['field'] . '_rel'] = 'ROUND( LOG2( ' . $column['field'] . ' / ' . $base .' ), 5)';
            }
        }

        return $fields;
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

    public function setTableModel($tableModel) {
        $this->tableModel = $tableModel;
    }
}