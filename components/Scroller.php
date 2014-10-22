<?php

namespace app\components;

use yii\data\Pagination;

/* This class implements a pagination class that is based on offset instead of page number
 * to be used for Datatables jquery plugin
 *
 */
class Scroller extends Pagination {
    public $offset;

    public function getOffset() {
        return $this->offset;
    }
}