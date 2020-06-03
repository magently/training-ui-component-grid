<?php

namespace Magently\MyUiComponent\Model\ResourceModel;

/**
 * MyProducts resource class
 */
class MyProducts extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * User construct function
     * @return void
     */
    protected function _construct()
    {
        $this->_init('my_products', 'entity_id');
    }
}
