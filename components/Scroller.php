<?php

namespace app\components;

use yii\data\Pagination;

/* This class implements a pagination class that is based on offset instead of page number
 * to be used for Datatables jquery plugin
 *
 */
class Scroller extends Pagination {
    /**
     * @var integer start of the request
     */
    public $offset;
    /**
     * @var integer a incremented counter of the request, in order to respond to asynchronous request
     */
    public $draw;

    /**
     * @var integer
     */
    public $unfilteredTotalCount;

    /**
     * @return int
     */
    public function getOffset() {
        return $this->offset;
    }
}