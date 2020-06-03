<?php

namespace Magently\MyUiComponent\Controller\Adminhtml\Index;

class InlineEdit extends \Magento\Backend\App\Action
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
     * @return type
     */
    public function execute()
    {
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        if (!$this->getRequest()->getParam('isAjax')) {
            $postItems = $this->getRequest()->getParam('items', []);
            /** $postItems	array[1]
                [2]	array[5]
                    [entity_id]     string	"2"
                    [is_active]     string	"1"
                    [last_update]	string	"05/27/2020"
                    [name]          string	"Laptop"
             */

            // ...
        }

        return $resultJson->setData(['messages' => $messages, 'error' => $error]);
    }
}

