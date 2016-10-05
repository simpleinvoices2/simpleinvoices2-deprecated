<?php
/**
 * @link      http://github.com/simpleinvoices2/simpleinvoices2
 * @copyright Copyright (c) 2016 Juan Pedro Gonzalez Gutierrez
 * @license   http://github.com/simpleinvoices2/simpleinvoices2/LICENSE GPL v3.0
 */

namespace SimpleInvoices\PaymentMethod;

/**
 * PaymentMethod
 * 
 * @author Juan Pedro Gonzalez Gutierrez
 */
class PaymentMethod implements PaymentMethodInterface
{
    /**
     * @var int
     */
    protected $domainId = 1;
    
    /**
     * @var bool
     */
    protected $enabled = true;
    
    /**
     * @var int
     */
    protected $id = 0;
    
    /**
     * @var string
     */
    protected $description;
    
    public function exchangeArray(array $data)
    {
        $this->id          = (!empty($data['pt_id']))          ? $data['pt_id']          : 0;
        $this->description = (!empty($data['pt_description'])) ? $data['pt_description'] : null;
        $this->enabled     = (isset($data['pt_enabled']))      ? $data['pt_enabled']     : true;
    }
    
    public function getDescription()
    {
        return $this->description;
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Check if the payment method is enabled.
     *
     * @return bool
     */
    public function isEnabled()
    {
        return $this->enabled;
    }
    
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }
    
    /**
     * Sets the payment method as enabled or disabled.
     *
     * @param bool $enabled
     * @return PaymentMethod
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
        return $this;
    }
    
    /**
     * Get the values as an array.
     *
     * Must match the identifiers on PaymentMethodForm.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'id'          => $this->id,
            'description' => $this->description,
            'enabled'     => $this->enabled,
        ];
    }
}