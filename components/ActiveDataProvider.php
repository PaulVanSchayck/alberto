<?php
namespace app\components;

use yii\base\InvalidConfigException;
use yii\db\QueryInterface;


/**
 * This extension to the ActiveDataProvider provides a count before and after filters
 *
 * Class ActiveDataProvider
 * @package app\components
 */
class ActiveDataProvider extends \yii\data\ActiveDataProvider {

    /**
     * Make the query unfiltered, to provide an unfiltered total count
     *
     * @return int The total count which is unfiltered
     *
     * @throws InvalidConfigException
     */
    public function getUnfilteredTotalCount()
    {
        if (!$this->query instanceof QueryInterface) {
            throw new InvalidConfigException('The "query" property must be an instance of a class that implements the QueryInterface e.g. yii\db\Query or its subclasses.');
        }
        $query = clone $this->query;
        return (int) $query->where(1)->limit(-1)->offset(-1)->orderBy([])->count('*', $this->db);
    }

    /**
     * Store the unfiltered total count in the pagination object
     *
     * @inheritdoc
     */
    protected function prepareModels()
    {
        if (($pagination = $this->getPagination()) !== false) {
            $pagination->unfilteredTotalCount = $this->getUnfilteredTotalCount();
        }

        return parent::prepareModels();
    }
}