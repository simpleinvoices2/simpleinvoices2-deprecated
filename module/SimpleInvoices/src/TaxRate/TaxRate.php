<?php
/**
 * @link      http://github.com/simpleinvoices2/simpleinvoices2
 * @copyright Copyright (c) 2016 Juan Pedro Gonzalez Gutierrez
 * @license   http://github.com/simpleinvoices2/simpleinvoices2/LICENSE GPL v3.0
 */

namespace SimpleInvoices\TaxRate;

class TaxRate implements TaxRateInterface
{
    protected $id = 0;
    protected $description;
    protected $percentage;
    protected $type = '%';
    protected $enabled = true;
    
    public function exchangeArray(array $data)
    {
        $this->id          = (!empty($data['tax_id']))          ? $data['tax_id']          : 0;
        $this->description = (!empty($data['tax_description'])) ? $data['tax_description'] : null;
        $this->percentage  = (!empty($data['tax_percentage']))  ? $data['tax_percentage']  : 0;
        $this->type        = (!empty($data['type']))            ? $data['type']            : '%';
        $this->enabled     = (isset($data['tax_enabled']))      ? $data['tax_enabled']     : true;
    }
    
    public function getDescription()
    {
        return $this->description;
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getPercentage()
    {
        return $this->percentage;
    }
    
    public function getType()
    {
        return $this->type;
    }
    
    public function isEnabled()
    {
        return $this->enabled;
    }
    
    
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }
    
    public function setPercentage($percentage)
    {
        $this->percentage = $percentage;
        return $this;
    }
    
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }
    
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
        return $this;
    }
    
    /**
     * Get the values as an array.
     * 
     * Must match the identifiers on TaxRateForm.
     * 
     * @return array
     */
    public function toArray()
    {
        return [
            'id'          => $this->id,
            'description' => $this->description,
            'percentage'  => $this->percentage,
            'type'        => $this->type,
            'enabled'     => $this->enabled,
        ];
    }
}