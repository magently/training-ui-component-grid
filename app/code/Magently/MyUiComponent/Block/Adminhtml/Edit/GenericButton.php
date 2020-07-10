<?php

namespace Magently\MyUiComponent\Block\Adminhtml\Edit;

use Magently\MyUiComponent\Controller\RegistryConstants;

/**
 * Base button class
 */
abstract class GenericButton
{
    /**
     * Url Builder
     *
     * @var \Magento\Framework\UrlInterface
     */
    protected $urlBuilder;

    /**
     * Registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $registry;

    /**
     * Constructor
     *
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry
    ) {
        $this->urlBuilder = $context->getUrlBuilder();
        $this->registry = $registry;
    }

    /**
     * Generate url by route and parameters
     *
     * @param string $route
     * @param array $params
     * @return string
     */
    public function getUrl(string $route = '', array $params = [])
    {
        return $this->urlBuilder->getUrl($route, $params);
    }

    /**
     * Return the MyProduct Id.
     *
     * @return integer|null
     */
    public function getMyProductId()
    {
        return $this->registry->registry(RegistryConstants::CURRENT_MYPRODUCT_ID);
    }
}