<?php
/**
 * @link      http://github.com/simpleinvoices2/simpleinvoices2
 * @copyright Copyright (c) 2016 Juan Pedro Gonzalez Gutierrez
 * @license   http://github.com/simpleinvoices2/simpleinvoices2/LICENSE GPL v3.0
 */

namespace SimpleInvoices\TaxRate;

interface TaxRateInterface
{
    /**
     * From array to object.
     * 
     * Used to convert the database data array to an object.
     * 
     * @param array $data
     * @return void
     */
    public function exchangeArray(array $data);

    /**
     * Get the tax rate description.
     * 
     * @return string|null
     */
    public function getDescription();

    /**
     * Get the tax rate ID.
     * 
     * @return int
     */
    public function getId();

    /**
     * Get the tax rate value.
     */
    public function getPercentage();

    /**
     * Get the tax rate type.
     * 
     * @return string
     */
    public function getType();

    /**
     * Check to see if the tax rate is enabled.
     * 
     * @return bool
     */
    public function isEnabled();

    /**
     * Sets the tax rate description.
     * 
     * @param string $description
     * @return TaxRateInterface
     */
    public function setDescription($description);

    /**
     * Sets the tax rate value.
     * 
     * @param unknown $percentage
     * @return TaxRateInterface
     */
    public function setPercentage($percentage);

    /**
     * Sets the tax rate type.
     * 
     * @param string $type
     * @return TaxRateInterface
     */
    public function setType($type);

    /**
     * Set if the tax rate is enabled or disabled.
     * 
     * @param bool $enabled
     * @return TaxRateInterface
     */
    public function setEnabled($enabled);
    
    /**
     * Get the values as an array.
     *
     * Must match the identifiers on TaxRateForm.
     *
     * @return array
     */
    public function toArray();
}