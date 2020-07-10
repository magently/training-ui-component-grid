<?php

namespace Magently\MyUiComponent\Controller\Adminhtml\Form;

use Magento\Framework\UrlInterface;

/**
 * Save MyProducts class
 */
class Save extends \Magento\Backend\App\Action
{
    /**
     * @var \Magently\MyUiComponent\Api\MyProductsRepositoryInterface
     */
    private $myProductsRepository;

    /**
     * @var \Magento\Framework\Api\DataObjectHelper
     */
    private $dataObjHelper;

    /**
     * @var \Magently\MyUiComponent\Api\Data\MyProductsInterfaceFactory
     */
    private $myProductFactory;

    /**
     * Constructor
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Api\DataObjectHelper $dataObjHelper
     * @param \Magently\MyUiComponent\Model\MyProductsRepository $myProductsRepository
     * @param \Magently\MyUiComponent\Api\Data\MyProductsInterfaceFactory $myProductFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Api\DataObjectHelper $dataObjHelper,
        \Magently\MyUiComponent\Api\MyProductsRepositoryInterface $myProductsRepository,
        \Magently\MyUiComponent\Api\Data\MyProductsInterfaceFactory $myProductFactory
    ) {
        parent::__construct($context);

        $this->myProductsRepository = $myProductsRepository;
        $this->dataObjHelper = $dataObjHelper;
        $this->myProductFactory = $myProductFactory;
    }

    /**
     * Save MyProducts action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        $returnToEdit = false;
        $myProductId = $this->getCurrentMyProductId();
        $data = $this->getRequest()->getPostValue();

        if ($data) {
            try {
                if (empty($data['entity_id'])) {
                    $data['entity_id'] = null;
                }

                // convert array to file path
                if (isset($data['image']) && is_array($data['image'])) {
                    if (isset($data['image'][0]['url']) && !isset($data['image'][0]['file'])) {
                        // image from gallery
                        $data['image'] = $data['image'][0]['url'];
                    } else {
                        // image from upload
                        if (strpos($data['image'][0]['file'], '/' . UrlInterface::URL_TYPE_MEDIA . '/') === 0) {
                            $data['image'] = $data['image'][0]['file'];
                        } else {
                            $data['image'] = '/' . UrlInterface::URL_TYPE_MEDIA . '/' . $data['image'][0]['file'];
                        }
                    }
                }

                /** @var \Magently\MyUiComponent\Api\Data\MyProductsInterface $myProduct */
                $myProduct = $this->myProductFactory->create();
                $this->dataObjHelper->populateWithArray(
                    $myProduct,
                    $data,
                    \Magently\MyUiComponent\Api\Data\MyProductsInterface::class
                );

                $myProductSaved = $this->myProductsRepository->save($myProduct);
                $myProductId = $myProductSaved->getEntityId();
                $returnToEdit = (bool)$this->getRequest()->getParam('back', false);
            } catch (\Exception $exc) {
                $this->getMessageManager()->addErrorMessage($exc->getMessage());
                $resultRedirect->setPath('my_products/form/index');
                return $resultRedirect;
            }

            $this->getMessageManager()->addSuccessMessage(__('My Product has been saved'));
            $resultRedirect->setPath(
                $returnToEdit ? 'my_products/form/index' : 'my_products/index/index',
                $returnToEdit ? ['id' => $myProductId] : []
            );
            return $resultRedirect;
        }

        $resultRedirect->setPath('my_products/form/index');
        return $resultRedirect;
    }

    /**
     * Retrieve current MyProducts ID
     *
     * @return integer|null
     */
    private function getCurrentMyProductId()
    {
        $data = $this->getRequest()->getPostValue();

        return $data['entity_id'] ?? null;
    }
}
