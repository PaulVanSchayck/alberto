<?php
namespace app\components;

class Serializer extends \yii\rest\Serializer {
    /**
     * @param Scroller $pagination
     * @return array
     */
    public function serializePagination($pagination) {
        return [
            'recordsTotal' => $pagination->totalCount,
            'recordsFiltered' => $pagination->totalCount,
            'draw' => $pagination->draw
        ];
    }
}