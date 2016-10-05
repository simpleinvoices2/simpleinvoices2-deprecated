<?php
/**
 * @link      http://github.com/simpleinvoices2/simpleinvoices2
 * @copyright Copyright (c) 2016 Juan Pedro Gonzalez Gutierrez
 * @license   http://github.com/simpleinvoices2/simpleinvoices2/LICENSE GPL v3.0
 */

namespace SimpleInvoices\PaymentMethod;

interface PaymentMethodInterface
{
    /**
     * Get the payment method description.
     * 
     * @return string
     */
    public function getDescription();

    /**
     * Get the payment method ID.
     * 
     * @return int
     */
    public function getId();
    
    /**
     * Check if the payment method is enabled.
     * 
     * @return bool
     */
    public function isEnabled();
    
    /**
     * Set the payment method description.
     * 
     * @param string $description
     * @return PaymentMethodInterface
     */
    public function setDescription($description);
    
    /**
     * Sets the payment method as enabled or disabled.
     * 
     * @param bool $enabled
     * @return PaymentMethodInterface
     */
    public function setEnabled($enabled);
    
}