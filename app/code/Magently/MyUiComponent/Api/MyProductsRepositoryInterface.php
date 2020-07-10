<?php

namespace Magently\MyUiComponent\Api;

use Magently\MyUiComponent\Api\Data\MyProductsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface MyProductsRepositoryInterface
{
    /**
     * @param MyProductsInterface $myProduct
     * @return MyProductsInterface
     */
    public function save(MyProductsInterface $myProduct);

    /**
     * @param integer $myProductId
     * @return MyProductsInterface
     */
    public function getById(int $myProductId);

    /**
     * @param SearchCriteriaInterface $criteria
     * @return mixed
     */
    public function getList(SearchCriteriaInterface $criteria);

    /**
     *
     * @param MyProductsInterface $myProduct
     * @return boolean
     */
    public function delete(MyProductsInterface $myProduct);

    /**
     *
     * @param integer $myProductId
     * @return boolean
     */
    public function deleteById(int $myProductId);
}

