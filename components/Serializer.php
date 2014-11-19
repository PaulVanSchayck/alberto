<?php
namespace app\components;

class Serializer extends \yii\rest\Serializer {

    /**
     * @var array Any extra fields of related models that you want to have included
     */
    public $extraFields = [];

    /**
     * @param Scroller $pagination
     * @return array
     */
    public function serializePagination($pagination) {
        return [
            'recordsTotal' => $pagination->unfilteredTotalCount,
            'recordsFiltered' => $pagination->totalCount,
            'draw' => $pagination->draw
        ];
    }

    protected function getRequestedFields() {
        return [
            [],
            $this->extraFields
        ];
    }
}