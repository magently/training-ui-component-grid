<?php

namespace Magently\MyUiComponent\Controller\Adminhtml\Index;

use Magento\Framework\Controller\ResultFactory;

class MassDelete extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Ui\Component\MassAction\Filter
     */
    private $filter;

    /**
     * @var \Magently\MyUiComponent\Model\ResourceModel\MyProducts\CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var \Magently\MyUiComponent\Api\MyProductsRepositoryInterface
     */
    private $productRepository;

    /**
     * Constructor
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Ui\Component\MassAction\Filter $filter
     * @param \Magently\MyUiComponent\Model\ResourceModel\MyProducts\CollectionFactory $collectionFactory
     * @param \Magently\MyUiComponent\Api\MyProductsRepositoryInterface $productRepository
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Ui\Component\MassAction\Filter $filter,
        \Magently\MyUiComponent\Model\ResourceModel\MyProducts\CollectionFactory $collectionFactory,
        \Magently\MyUiComponent\Api\MyProductsRepositoryInterface $productRepository
    ) {
        parent::__construct($context);
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->productRepository = $productRepository;
    }

    /**
     * Execute the action.
     *
     * @return \Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $productDeleted = 0;
        /** @var \Magento\Catalog\Model\Product $product */
        foreach ($collection->getItems() as $product) {
            //$this->productRepository->delete($product); // uncomment for real delete
            $productDeleted++;
        }

        if ($productDeleted) {
            $this->messageManager->addSuccessMessage(
                __('A total of %1 record(s) have been deleted.', $productDeleted)
            );
        }

        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('*/*/index');
    }
}
