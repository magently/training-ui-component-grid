<?php

namespace Magently\MyUiComponent\Model\MyProducts;

use Magently\MyUiComponent\Model\ResourceModel\MyProducts\CollectionFactory;

/**
 * Data provider for UI Componetn form
 */
class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var array
     */
    private $loadedData;

    /**
     * Constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (!empty($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();
        foreach ($items as $myProduct) {
            $this->loadedData[$myProduct->getId()] = $myProduct->getData();
            if (!empty($this->loadedData[$myProduct->getId()]['image'])) {
                // convert string with image file name to array needed for image uploader
                $this->loadedData[$myProduct->getId()]['image'] = [
                    0 => $this->getImageUploaderData($this->loadedData[$myProduct->getId()]['image'])
                ];
            }
        }
        return $this->loadedData;
    }

    /**
     * Return array with data needed for image uploader control
     *
     * @param string $fileName
     * @return array
     */
    private function getImageUploaderData(string $fileName)
    {
        return [
            'name' => $fileName,
            'file' => $fileName,
            'url' => $fileName,
            'previewType' => 'image',
            'size' => filesize(substr($fileName, 1)), // cut first '/'
            'type' => mime_content_type(substr($fileName, 1)),
        ];
    }
}
