<?php

namespace Magently\MyUiComponent\Api;

use Magently\MyUiComponent\Api\Data\MyProductsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface MyProductsRepositoryInterface
{
    /**
     * @param MyProductsInterface $page
     * @return mixed
     */
    public function save(MyProductsInterface $page);

    /**
     * @param integer $userId
     * @return mixed
     */
    public function getById(int $userId);

    /**
     * @param SearchCriteriaInterface $criteria
     * @return mixed
     */
    public function getList(SearchCriteriaInterface $criteria);

    /**
     *
     * @param MyProductsInterface $page
     * @return mixed
     */
    public function delete(MyProductsInterface $page);

    /**
     *
     * @param integer $userId
     * @return mixed
     */
    public function deleteById(int $userId);
}

