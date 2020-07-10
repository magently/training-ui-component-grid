<?php

namespace Magently\MyUiComponent\Controller\Adminhtml\Form;

/**
 * Validate MyProducts class
 */
class Validate extends \Magento\Backend\App\Action
{
    /**
     * @var Magento\Framework\Controller\Result\JsonFactory
     */
    private $jsonFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Controller\Result\JsonFactory $jsonFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $jsonFactory
    ) {
        parent::__construct($context);
        $this->jsonFactory = $jsonFactory;
    }

    /**
     * AJAX validation action
     *
     * @return \Magento\Framework\Controller\Result\Json
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $response = new \Magento\Framework\DataObject();
        $response->setError(false);

        //$response->setError(true);
        //$response->setMessages([__('Some error message')]);

        return $this->jsonFactory->create()->setData($response);
    }
}
