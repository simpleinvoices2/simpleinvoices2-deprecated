<?php
/**
 * @link      http://github.com/simpleinvoices2/simpleinvoices2
 * @copyright Copyright (c) 2016 Juan Pedro Gonzalez Gutierrez
 * @license   http://github.com/simpleinvoices2/simpleinvoices2/LICENSE GPL v3.0
 */

namespace SimpleInvoices\TaxRate;

use Zend\EventManager\EventManagerAwareInterface;

interface TaxRateManagerInterface extends EventManagerAwareInterface
{
    /**
     * Delete a tax rate.
     * 
     * @param TaxRateInterface|int $tax Can either be the tax rate ID or a TaxRateInterface object.
     */
    public function delete($tax);
    
    /**
     * Get all tax rates.
     *
     * @param bool $paginated
     * @return \Zend\Paginator\Paginator|\Zend\Db\ResultSet\ResultSet
     */
    public function getAllTaxes($paginated = false);
    
    /**
     * Get the event.
     *
     * @return \SimpleInvoices\Core\EventManager\SqlEvent
     */
    public function getEvent();
    
    /**
     * Get the given tax rate.
     * 
     * @param int $id The tax rate ID.
     */
    public function getTax($id);
    
    /**
     * Get the tax rate prototype class.
     *
     * @return TaxRateInterface
     */
    public function getTaxRatePrototype();
    
    /**
     * Save a tax rate.
     * 
     * @param TaxRateInterface $tax
     */
    public function save(TaxRateInterface $tax);
    
}