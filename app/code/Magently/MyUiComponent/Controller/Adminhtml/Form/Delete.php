<?php

namespace Magently\MyUiComponent\Controller\Adminhtml\Form;

/**
 * Delete action
 */
class Delete extends \Magento\Backend\App\Action
{
    /**
     * @var \Magently\MyUiComponent\Api\MyProductsRepositoryInterface
     */
    private $myProductsRepository;

    /**
     * Constructor
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magently\MyUiComponent\Model\MyProductsRepository $myProductsRepository
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magently\MyUiComponent\Api\MyProductsRepositoryInterface $myProductsRepository
    ) {
        parent::__construct($context);

        $this->myProductsRepository = $myProductsRepository;
    }

    /**
     * Handle delete action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('*/index/index');

        $myProductId = (int)$this->getRequest()->getParam('id');
        if ($myProductId) {
            try {
                $this->myProductsRepository->deleteById($myProductId);
                $this->messageManager->addSuccessMessage(__('My Product has been deleted'));
            } catch (\Exception $exc) {
                $this->messageManager->addErrorMessage(__('Something went wrong while trying to delete My Product.'));
                $resultRedirect->setPath('*/form/index', ['id' => $myProductId]);
            }
        }

        return $resultRedirect;
    }
}
