<?php
/**
 * @link      http://github.com/simpleinvoices2/simpleinvoices2
 * @copyright Copyright (c) 2016 Juan Pedro Gonzalez Gutierrez
 * @license   http://github.com/simpleinvoices2/simpleinvoices2/LICENSE GPL v3.0
 */

namespace SimpleInvoices\Customer;

interface CustomerInterface
{
    /**
     * Get the customer ID.
     *
     * @return int The customer ID.
     */
    public function getId();
    
    /**
     * Get the customer name.
     *
     * return string
     */
    public function getName();
    
    /**
     * Get the first line of the street address of the customer.
     *
     * @return NULL|string
     */
    public function getStreetAddress();
    
    /**
     * Get the second line of the street address of the customer.
     *
     * @return NULL|string
     */
    public function getStreetAddress2();
    
    /**
     * Get the city of the customer.
     *
     * @return NULL|string
     */
    public function getCity();
    
    /**
     * Get the state address of the customer.
     *
     * @return NULL|string
     */
    public function getState();
    
    /**
     * Get the ZIP code of the customer.
     *
     * @return NULL|string
     */
    public function getZipCode();
    
    /**
     * Get the country name of the customer.
     *
     * @return NULL|string
     */
    public function getCountry();
    
    /**
     * Get the customer's phone number.
     *
     * @return NULL|string
     */
    public function getPhone();
    
    /**
     * Get the customer's mobile phone number.
     *
     * @return NULL|string
     */
    public function getMobilePhone();
    
    /**
     * Get the customer's FAX number.
     *
     * @return NULL|string
     */
    public function getFax();
    
    /**
     * Get the customer's email address.
     *
     * @return null|string
     */
    public function getEmailAddress();
    
    /**
     * Get comments about the customer.
     *
     * @return null|string
     */
    public function getComments();
    
    /**
     * Check if the customer is enabled.
     *
     *  @return bool
     */
    public function isEnabled();
    
    /**
     * Set the customer name.
     *
     * @param string $name
     * @return CustomerInterface
     */
    public function setName($name);
    
    /**
     * Set the first line of the street address of the customer.
     *
     * @param string $street
     * @return CustomerInterface
     */
    public function setStreetAddress($street);
    
    /**
     * Set the second line of the street address of the customer.
     *
     * @param string $street
     * @return CustomerInterface
     */
    public function setStreetAddress2($street);
    
    /**
     * Set the city of the customer.
     *
     * @param string $city
     * @return CustomerInterface
     */
    public function setCity($city);
    
    /**
     * Set the state address of the customer.
     *
     * @param string $state
     * @return CustomerInterface
     */
    public function setState($state);
    
    /**
     * Set the ZIP code of the customer.
     *
     * @param string $zipCode
     * @return CustomerInterface
     */
    public function setZipCode($zipCode);
    
    /**
     * Set the country name of the customer.
     *
     * @param string $country
     * @return CustomerInterface
     */
    public function setCountry($country);
    
    /**
     * Set the customer's phone number.
     *
     * @param string $phone
     * @return CustomerInterface
     */
    public function setPhone($phone);
    
    /**
     * Set the customer's mobile phone number.
     *
     * @param string $phone
     * @return CustomerInterface
     */
    public function setMobilePhone($phone);
    
    /**
     * Set the customer's FAX number.
     *
     * @param string $fax
     * @return CustomerInterface
     */
    public function setFax($fax);
    
    /**
     * Set the customer's email address.
     *
     * @param string $emailAddress
     * @return CustomerInterface
     */
    public function setEmailAddress($emailAddress);
    
    /**
     * Set comments about the customer.
     *
     * @param string $comments
     * @return CustomerInterface
     */
    public function setComments($comments);
    
    /**
     * Set if the customer is enabled.
     *
     * @param bool $enabled
     * @return CustomerInterface
     */
    public function setEnabled($enabled);
}