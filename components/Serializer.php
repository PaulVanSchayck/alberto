<?php
namespace app\components;

use yii\data\DataProviderInterface;

class Serializer extends \yii\rest\Serializer {
    public $draw = "";

    /**
     * @param \yii\data\Pagination $pagination
     * @return array
     */
    public function serializePagination() {
        return [
            'recordsTotal' => 25000,
            'recordsFiltered' => 25000,
            'draw' => $this->draw
        ];
    }

    /**
     * Serializes a data provider.
     * @param DataProviderInterface $dataProvider
     * @return array the array representation of the data provider.
     */
    protected function serializeDataProvider($dataProvider)
    {
        $models = $this->serializeModels($dataProvider->getModels());

        if ($this->request->getIsHead()) {
            return null;
        } elseif ($this->collectionEnvelope === null) {
            return $models;
        } else {
            $result = [
                $this->collectionEnvelope => $models,
            ];
            return array_merge($result, $this->serializePagination());
        }
    }
}