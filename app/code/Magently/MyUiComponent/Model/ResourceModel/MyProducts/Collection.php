<?php

namespace Magently\MyUiComponent\Model\ResourceModel\MyProducts;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magently\MyUiComponent\Model\MyProducts as Model;
use Magently\MyUiComponent\Model\ResourceModel\MyProducts as ResourceModel;

/**
 * MyProducts Collection
 */
class Collection extends AbstractCollection
{
    /**
     * Identifier field name for collection items
     *
     * Needed for using \Magento\Ui\Component\MassAction\Filter
     *
     * @var string
     */
    protected $_idFieldName = 'entity_id';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            Model::class,
            ResourceModel::class
        );
    }
}
