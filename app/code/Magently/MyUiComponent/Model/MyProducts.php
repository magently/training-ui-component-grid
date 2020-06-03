<?php

namespace Magently\MyUiComponent\Model;

use Magento\Framework\Model\AbstractExtensibleModel;
use Magently\MyUiComponent\Api\Data\MyProductsInterface;
use Magento\Framework\DataObject\IdentityInterface;

class MyProducts extends AbstractExtensibleModel implements MyProductsInterface, IdentityInterface
{
    const CACHE_TAG = 'magently_myproducts';

    /**
     * MyProducts model construct function.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Magently\MyUiComponent\Model\ResourceModel\MyProducts::class);
    }

    /**
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * Set name
     *
     * @param string|null $name
     * @return this
     */
    public function setName($name)
    {
        return $this->setData('name', $name);
    }

    /**
     * Get name
     *
     * @return string|null
     */
    public function getName()
    {
        return $this->getData('name');
    }

    /**
     * Set price
     *
     * @param float|null $price
     * @return this
     */
    public function setPrice($price)
    {
        return $this->setData('price', $price);
    }

    /**
     * Get price
     *
     * @return float|null
     */
    public function getPrice()
    {
        return $this->getData('price');
    }

    /**
     * Set image
     *
     * @param string|null $image
     * @return this
     */
    public function setImage($image)
    {
        return $this->setData('image', $image);
    }

    /**
     * Get image
     *
     * @return string|null
     */
    public function getImage()
    {
        return $this->getData('image');
    }

    /**
     * Set description
     *
     * @param string|null $description
     * @return this
     */
    public function setDescription($description)
    {
        return $this->setData('description', $description);
    }

    /**
     * Get description
     *
     * @return string|null
     */
    public function getDescription()
    {
        return $this->getData('description');
    }

    /**
     * Set last update date
     *
     * @param string|null $lastUpdate
     * @return this
     */
    public function setLastUpdate($lastUpdate)
    {
        return $this->setData('last_update', $lastUpdate);
    }

    /**
     * Get last update date
     *
     * @return string|null
     */
    public function getLastUpdate()
    {
        return $this->getData('last_update');
    }

    /**
     * Set is active
     *
     * @param boolean $isActive
     * @return this
     */
    public function setIsActive(bool $isActive)
    {
        return $this->setData('is_active', $isActive);
    }

    /**
     * Get is acrive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->getData('is_active');
    }
}
