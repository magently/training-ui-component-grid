<?php

namespace Magently\MyUiComponent\Api\Data;

interface MyProductsInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{
    /**
     * Set name
     *
     * @param string|null $name
     * @return this
     */
    public function setName($name);

    /**
     * Get name
     *
     * @return string|null
     */
    public function getName();

    /**
     * Set price
     *
     * @param float|null $price
     * @return this
     */
    public function setPrice($price);

    /**
     * Get price
     *
     * @return float|null
     */
    public function getPrice();

    /**
     * Set image
     *
     * @param string|null $image
     * @return this
     */
    public function setImage($image);

    /**
     * Get image
     *
     * @return string|null
     */
    public function getImage();

    /**
     * Set description
     *
     * @param string|null $description
     * @return this
     */
    public function setDescription($description);

    /**
     * Get description
     *
     * @return string|null
     */
    public function getDescription();

    /**
     * Set last update date
     *
     * @param string|null $lastUpdate
     * @return this
     */
    public function setLastUpdate($lastUpdate);

    /**
     * Get last update date
     *
     * @return string|null
     */
    public function getLastUpdate();

    /**
     * Set is active
     *
     * @param boolean $isActive
     * @return this
     */
    public function setIsActive(bool $isActive);

    /**
     * Get is active
     *
     * @return boolean
     */
    public function getIsActive();
}
