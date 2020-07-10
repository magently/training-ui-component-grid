<?php

namespace Magently\MyUiComponent\Controller\Adminhtml\Form;

use Magento\Framework\Controller\ResultFactory;
use Magently\MyUiComponent\Controller\RegistryConstants;

class Index extends \Magento\Backend\App\Action
{
    /**
     * Page result model
     *
     * @var \Magento\Backend\Model\View\Result\Page
     */
    private $resultPage;

    /**
     * @var \Magento\Framework\Registry
     */
    private $coreRegistry;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry
    ) {
        parent::__construct($context);

        $this->coreRegistry = $coreRegistry;
    }

    /**
     * Execute the action
     *
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $this->initCurrentMyProduct();

        if (!$this->resultPage) {
            $this->resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        }
        return $this->resultPage;
    }

    /**
     * Customer initialization
     *
     * @return string customer id
     */
    private function initCurrentMyProduct()
    {
        $myProductId = (int)$this->getRequest()->getParam('id');

        if ($myProductId) {
            $this->coreRegistry->register(RegistryConstants::CURRENT_MYPRODUCT_ID, $myProductId);
        }

        return $myProductId;
    }
}
