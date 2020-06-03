<?php

namespace Magently\MyUiComponent\Ui\Component\Listing\Columns;

/**
 * Class for displaying images in UI Component Grid view
 */
class Image extends \Magento\Ui\Component\Listing\Columns\Column
{
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    /**
     * @param \Magento\Framework\View\Element\UiComponent\ContextInterface $context
     * @param \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param array $components
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->storeManager = $storeManager;
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            // get URL to media directory, e.g. http://localhost/magento/media/
            $urlMedia = $this->storeManager
                ->getStore()
                ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);

            $fieldName = $this->getData('name'); // get field name, in our case it's "image"

            foreach ($dataSource['data']['items'] as & $item) {
                $image = (new \Magento\Framework\DataObject($item))->getImage();
                if (empty($image)) {
                    $item[$fieldName . '_alt'] = __('No image');
                    continue;
                }

                $src = $urlMedia . $image; // prepare link to big image

                $item[$fieldName . '_src'] = $src; // URL to thumbnail image
                $item[$fieldName . '_alt'] = $item['name']; // alt text
                $item[$fieldName . '_link'] = $src; // URL for "Go to Details Page" link in preview
                $item[$fieldName . '_orig_src'] = $src; // URL to big image
            }
        }

        return $dataSource;
    }
}
