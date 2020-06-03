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
     * @var object
     */
    private $objectFactory;

    /**
     * @var object
     */
    private $collectionFactory;

    /**
     * @var SearchResultsInterfaceFactory
     */
    private $searchResultsFactory;

    /**
     * Constructor.
     *
     * @param MyProductsFactory $objectFactory
     * @param CollectionFactory $collectionFactory
     * @param SearchResultsInterfaceFactory $searchResultsFactory
     */
    public function __construct(
        MyProductsFactory $objectFactory,
        CollectionFactory $collectionFactory,
        SearchResultsInterfaceFactory $searchResultsFactory
    ) {
        $this->objectFactory = $objectFactory;
        $this->collectionFactory = $collectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
    }

    /**
     * @param MyProductsInterface $object
     * @return MyProductsInterface
     * @throws CouldNotSaveException Save failed.
     */
    public function save(MyProductsInterface $object)
    {
        try {
            $object->save();
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        }
        return $object;
    }

    /**
     * @param MyProductsInterface $object
     * @return boolean
     * @throws CouldNotDeleteException Delete failed.
     */
    public function delete(MyProductsInterface $object)
    {
        try {
            $object->delete();
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    /**
     * Get object by ID
     *
     * @param integer $objectId
     * @return object
     * @throws NoSuchEntityException ID not found.
     */
    public function getById(int $objectId)
    {
        $object = $this->objectFactory->create();
        $object->load($objectId);
        if (!$object->getId()) {
            throw new NoSuchEntityException(__('Object with id "%1" does not exist.', $objectId));
        }
        return $object;
    }

    /**
     * @param integer $objectId
     * @return object
     */
    public function deleteById(int $objectId)
    {
        return $this->delete($this->getById($objectId));
    }

    /**
     *
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

