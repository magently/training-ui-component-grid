<?php

namespace Magently\MyUiComponent\Ui\Component\Listing\Columns;

/**
 * Class for displaying actions colum in UI Component Grid view
 */
class BlockActions extends \Magento\Ui\Component\Listing\Columns\Column
{
    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $item[$this->getData('name')] = [
                    'edit' => [
                        'href' => $this->getContext()->getUrl(
                            '*/*/edit',
                            ['id' => $item['entity_id']]
                        ),
                        'label' => __('Edit')
                    ],
                    'delete' => [
                        'href' => $this->getContext()->getUrl(
                            '*/*/delete',
                            ['id' => $item['entity_id']]
                        ),
                        'label' => __('Delete'),
                        'confirm' => [
                            'title' => __('Delete'),
                            'message' => __('Are you sure you want to delete this item?')
                        ]
                    ]
                ];
            }
        }

        return $dataSource;
    }
}
