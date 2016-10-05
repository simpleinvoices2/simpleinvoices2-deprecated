<?php
/**
 * @link      http://github.com/simpleinvoices2/simpleinvoices2
 * @copyright Copyright (c) 2016 Juan Pedro Gonzalez Gutierrez
 * @license   http://github.com/simpleinvoices2/simpleinvoices2/LICENSE GPL v3.0
 */

namespace SimpleInvoices\Biller;

interface BillerInterface
{
    /**
     * Get the biller ID.
     *
     * @return int The biller ID.
     */
    public function getId();
    
    /**
     * Get the biller name.
     *
     * return string
     */
    public function getName();
    
    /**
     * Get the first line of the street address of the biller.
     *
     * @return NULL|string
     */
    public function getStreetAddress();
    
    /**
     * Get the second line of the street address of the biller.
     *
     * @return NULL|string
     */
    public function getStreetAddress2();
    
    /**
     * Get the city of the biller.
     *
     * @return NULL|string
     */
    public function getCity();
    
    /**
     * Get the state address of the biller.
     *
     * @return NULL|string
     */
    public function getState();
    
    /**
     * Get the ZIP code of the biller.
     *
     * @return NULL|string
     */
    public function getZipCode();
    
    /**
     * Get the country name of the biller.
     *
     * @return NULL|string
     */
    public function getCountry();
    
    /**
     * Get the biller's phone number.
     *
     * @return NULL|string
     */
    public function getPhone();
    
    /**
     * Get the biller's mobile phone number.
     *
     * @return NULL|string
     */
    public function getMobilePhone();
    
    /**
     * Get the biller's FAX number.
     *
     * @return NULL|string
     */
    public function getFax();
    
    /**
     * Get the biller's email address.
     *
     * @return null|string
     */
    public function getEmailAddress();
    
    /**
     * Get comments about the biller.
     *
     * @return null|string
     */
    public function getComments();
    
    /**
     * Check if the biller is enabled.
     *
     *  @return bool
     */
    public function isEnabled();
    
    /**
     * Set the biller name.
     *
     * @param string $name
     * @return BillerInterface
     */
    public function setName($name);
    
    /**
     * Set the first line of the street address of the biller.
     *
     * @param string $street
     * @return BillerInterface
     */
    public function setStreetAddress($street);
    
    /**
     * Set the second line of the street address of the biller.
     *
     * @param string $street
     * @return BillerInterface
     */
    public function setStreetAddress2($street);
    
    /**
     * Set the city of the biller.
     *
     * @param string $city
     * @return BillerInterface
     */
    public function setCity($city);
    
    /**
     * Set the state address of the biller.
     *
     * @param string $state
     * @return BillerInterface
     */
    public function setState($state);
    
    /**
     * Set the ZIP code of the biller.
     *
     * @param string $zipCode
     * @return BillerInterface
     */
    public function setZipCode($zipCode);
    
    /**
     * Set the country name of the biller.
     *
     * @param string $country
     * @return BillerInterface
     */
    public function setCountry($country);
    
    /**
     * Set the biller's phone number.
     *
     * @param string $phone
     * @return BillerInterface
     */
    public function setPhone($phone);
    
    /**
     * Set the biller's mobile phone number.
     *
     * @param string $phone
     * @return BillerInterface
     */
    public function setMobilePhone($phone);
    
    /**
     * Set the biller's FAX number.
     *
     * @param string $fax
     * @return BillerInterface
     */
    public function setFax($fax);
    
    /**
     * Set the biller's email address.
     *
     * @param string $emailAddress
     * @return BillerInterface
     */
    public function setEmailAddress($emailAddress);
    
    /**
     * Set comments about the biller.
     *
     * @param string $comments
     * @return BillerInterface
     */
    public function setComments($comments);
    
    /**
     * Set if the biller is enabled.
     *
     * @param bool $enabled
     * @return BillerInterface
     */
    public function setEnabled($enabled);
}