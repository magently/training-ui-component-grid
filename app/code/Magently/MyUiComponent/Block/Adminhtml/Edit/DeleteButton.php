<?php

namespace Magently\MyUiComponent\Block\Adminhtml\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Delete button class
 */
class DeleteButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Delete'),
            'class' => 'delete',
            'on_click' => "deleteConfirm('" .__('Are you sure you want to delete this MyProduct?') ."', '"
                    . $this->getDeleteUrl() . "', {data: {}})",
            'sort_order' => 20,
        ];
    }

    /**
     * Get URL for delete button
     *
     * @return string
     */
    public function getDeleteUrl()
    {
        return $this->getUrl('my_products/form/delete', ['id' => $this->getMyProductId()]);
    }
}
