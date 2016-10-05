<?php
/**
 * @link      http://github.com/simpleinvoices2/simpleinvoices2
 * @copyright Copyright (c) 2016 Juan Pedro Gonzalez Gutierrez
 * @license   http://github.com/simpleinvoices2/simpleinvoices2/LICENSE GPL v3.0
 */

namespace SimpleInvoices\Biller;

/**
 * Credit card storage has been removed as it is illegal at Spain and other countries.
 * If you wish to store Credit Card data, write a plugin.
 * 
 * Custom fields have been removed but may be added in the future.
 * 
 * @author Juan Pedro Gonzalez Gutierrez
 */
class Biller implements BillerInterface
{
    protected $id;
    protected $name;
    protected $streetAddress;
    protected $streetAddress2;
    protected $city;
    protected $state;
    protected $zipCode;
    protected $country;
    protected $phone;
    protected $mobilePhone;
    protected $fax;
    protected $emailAddress;
    protected $comments;
    protected $enabled = true;
    
    public function exchangeArray(array $data)
    {
        $this->id             = (!empty($data['id']))              ? $data['id']              : 0;
        $this->name           = (!empty($data['name']))            ? $data['name']            : null;
        $this->streetAddress  = (!empty($data['street_address']))  ? $data['street_address']  : null;
        $this->streetAddress2 = (!empty($data['street_address2'])) ? $data['street_address2'] : null;
        $this->city           = (!empty($data['city']))            ? $data['city']            : null;
        $this->state          = (!empty($data['state']))           ? $data['state']           : null;
        $this->zipCode        = (!empty($data['zip_code']))        ? $data['zip_code']        : null;
        $this->country        = (!empty($data['country']))         ? $data['country']         : null;
        $this->phone          = (!empty($data['phone']))           ? $data['phone']           : null;
        $this->mobilePhone    = (!empty($data['mobile_phone']))    ? $data['mobile_phone']    : null;
        $this->fax            = (!empty($data['fax']))             ? $data['fax']             : null;
        $this->emailAddress   = (!empty($data['email']))           ? $data['email']           : null;
        $this->comments       = (!empty($data['notes']))           ? $data['notes']           : null;
        $this->enabled        = (isset($data['enabled']))          ? $data['enabled']         : true;
    }
    
    /**
     * Get the biller ID.
     * 
     * @return int The biller ID.
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Get the biller name.
     * 
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Get the first line of the street address of the biller.
     * 
     * @return NULL|string
     */
    public function getStreetAddress()
    {
        return $this->streetAddress;
    }
    
    /**
     * Get the second line of the street address of the biller.
     *
     * @return NULL|string
     */
    public function getStreetAddress2()
    {
        return $this->streetAddress2;
    }
    
    /**
     * Get the city of the biller.
     *
     * @return NULL|string
     */
    public function getCity()
    {
        return $this->city;
    }
    
    /**
     * Get the state address of the biller.
     * 
     * @return NULL|string
     */
    public function getState()
    {
        return $this->state;
    }
    
    /**
     * Get the ZIP code of the biller.
     * 
     * @return NULL|string
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }
    
    /**
     * Get the country name of the biller.
     * 
     * @return NULL|string
     */
    public function getCountry()
    {
        return $this->country;
    }
    
    /**
     * Get the biller's phone number.
     * 
     * @return NULL|string
     */
    public function getPhone()
    {
        return $this->phone;
    }
    
    /**
     * Get the biller's mobile phone number.
     * 
     * @return NULL|string
     */
    public function getMobilePhone()
    {
        return $this->mobilePhone;
    }
    
    /**
     * Get the biller's FAX number.
     * 
     * @return NULL|string
     */
    public function getFax()
    {
        return $this->fax;
    }
    
    /**
     * Get the biller's email address.
     * 
     * @return null|string
     */
    public function getEmailAddress()
    {
        return $this->emailAddress;
    }
    
    /**
     * Get comments about the biller.
     * 
     * @return null|string
     */
    public function getComments()
    {
        return $this->comments;
    }
    
    /**
     * Check if the biller is enabled.
     * 
     *  @return bool
     */
    public function isEnabled()
    {
        return $this->enabled;
    }
    
    
    /**
     * Set the biller name.
     *
     * @param string $name
     * @return Biller
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
    
    /**
     * Set the first line of the street address of the biller.
     *
     * @param string $street
     * @return Biller
     */
    public function setStreetAddress($street)
    {
        $this->streetAddress = $street;
        return $this;
    }
    
    /**
     * Set the second line of the street address of the biller.
     *
     * @param string $street
     * @return Biller
     */
    public function setStreetAddress2($street)
    {
        $this->streetAddress2 = $street;
        return $this;
    }
    
    /**
     * Set the city of the biller.
     *
     * @param string $city
     * @return Biller
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }
    
    /**
     * Set the state address of the biller.
     *
     * @param string $state
     * @return Biller
     */
    public function setState($state)
    {
        $this->state = $state;
        return $this;
    }
    
    /**
     * Set the ZIP code of the biller.
     *
     * @param string $zipCode
     * @return Biller
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;
        return $this;
    }
    
    /**
     * Set the country name of the biller.
     *
     * @param string $country
     * @return Biller
     */
    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }
    
    /**
     * Set the biller's phone number.
     *
     * @param string $phone
     * @return Biller
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }
    
    /**
     * Set the biller's mobile phone number.
     *
     * @param string $phone
     * @return Biller
     */
    public function setMobilePhone($phone)
    {
        $this->mobilePhone = $phone;
        return $this;
    }
    
    /**
     * Set the biller's FAX number.
     *
     * @param string $fax
     * @return Biller
     */
    public function setFax($fax)
    {
        $this->fax = $fax;
        return $this;
    }
    
    /**
     * Set the biller's email address.
     *
     * @param string $emailAddress
     * @return Biller
     */
    public function setEmailAddress($emailAddress)
    {
        $this->emailAddress = $emailAddress;
        return $this;
    }
    
    /**
     * Set comments about the biller.
     *
     * @param string $comments
     * @return Biller
     */
    public function setComments($comments)
    {
        $this->comments = $comments;
        return $this;
    }
    
    /**
     * Set if the biller is enabled.
     * 
     * @param bool $enabled
     * @return Biller
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
        return $this;
    }
    
    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'street_address' => $this->streetAddress,
            'street_address2' => $this->streetAddress2,
            'city' => $this->city,
            'state' => $this->state,
            'zip_code' => $this->zipCode,
            'country' => $this->country,
            'phone' => $this->phone,
            'mobile_phone' => $this->mobilePhone,
            'fax' => $this->fax,
            'email' => $this->emailAddress,
            'comments' => $this->comments,
            'enabled' => $this->enabled,
        ];
    }
}