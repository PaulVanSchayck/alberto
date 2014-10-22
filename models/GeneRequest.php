<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * GeneRequest is the model behind the requests of DataTables
 */
class GeneRequest extends Model {

    public $start;
    public $draw;
    public $length = 10;

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
            // draw and page are required
            [['draw', 'start'], 'required'],
            [['draw', 'length'], 'integer']
        ];
    }

    public function getPaginationConfig() {
        return [
            'pageSize' => $this->length,
            'page' => $this->start
        ];
    }

}