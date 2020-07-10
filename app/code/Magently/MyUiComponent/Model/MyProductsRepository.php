<?php

namespace Magently\MyUiComponent\Model;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterfaceFactory;
use Magently\MyUiComponent\Api\MyProductsRepositoryInterface;
use Magently\MyUiComponent\Api\Data\MyProductsInterface;
use Magently\MyUiComponent\Model\MyProductsFactory;
use Magently\MyUiComponent\Model\ResourceModel\MyProducts\CollectionFactory;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;

class MyProductsRepository implements MyProductsRepositoryInterface
{
    /**
     * @var MyProductsFactory
     */
    private $myProductsFactory;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var SearchResultsInterfaceFactory
     */
    private $searchResultsFactory;

    /**
     * Constructor.
     *
     * @param MyProductsFactory $myProductsFactory
     * @param CollectionFactory $collectionFactory
     * @param SearchResultsInterfaceFactory $searchResultsFactory
     */
    public function __construct(
        MyProductsFactory $myProductsFactory,
        CollectionFactory $collectionFactory,
        SearchResultsInterfaceFactory $searchResultsFactory
    ) {
        $this->myProductsFactory = $myProductsFactory;
        $this->collectionFactory = $collectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
    }

    /**
     * @param MyProductsInterface $myProduct
     * @return MyProductsInterface
     * @throws CouldNotSaveException Save failed.
     */
    public function save(MyProductsInterface $myProduct)
    {
        try {
            $myProduct->save();
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        }
        return $myProduct;
    }

    /**
     * @param MyProductsInterface $myProduct
     * @return boolean
     * @throws CouldNotDeleteException Delete failed.
     */
    public function delete(MyProductsInterface $myProduct)
    {
        try {
            $myProduct->delete();
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    /**
     * Get MyProduct by ID
     *
     * @param integer $myProductId
     * @return MyProductsInterface
     * @throws NoSuchEntityException ID not found.
     */
    public function getById(int $myProductId)
    {
        $myProduct = $this->myProductsFactory->create();
        $myProduct->load($myProductId);
        if (!$myProduct->getId()) {
            throw new NoSuchEntityException(__('MyProduct with id "%1" does not exist.', $myProductId));
        }
        return $myProduct;
    }

    /**
     * @param integer $myProductId
     * @return boolean
     */
    public function deleteById(int $myProductId)
    {
        return $this->delete($this->getById($myProductId));
    }

    /**
     * @param SearchCriteriaInterface $criteria
     * @return object
     */
    public function getList(SearchCriteriaInterface $criteria)
    {
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $collection = $this->collectionFactory->create();
        foreach ($criteria->getFilterGroups() as $filterGroup) {
            $fields = [];
            $conditions = [];
            foreach ($filterGroup->getFilters() as $filter) {
                $condition = $filter->getConditionType() ? $filter->getConditionType() : 'eq';
                $fields[] = $filter->getField();
                $conditions[] = [$condition => $filter->getValue()];
            }
            if ($fields) {
                $collection->addFieldToFilter($fields, $conditions);
            }
        }
        $searchResults->setTotalCount($collection->getSize());
        $sortOrders = $criteria->getSortOrders();
        if ($sortOrders) {
            /** @var SortOrder $sortOrder */
            foreach ($sortOrders as $sortOrder) {
                $collection->addOrder(
                    $sortOrder->getField(),
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        }
        $collection->setCurPage($criteria->getCurrentPage());
        $collection->setPageSize($criteria->getPageSize());
        $objects = [];
        foreach ($collection as $objectModel) {
            $objects[] = $objectModel;
        }
        $searchResults->setItems($objects);
        return $searchResults;
    }
}

