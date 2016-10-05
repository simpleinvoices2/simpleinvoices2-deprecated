<?php
/**
 * @link      http://github.com/simpleinvoices2/simpleinvoices2
 * @copyright Copyright (c) 2016 Juan Pedro Gonzalez Gutierrez
 * @license   http://github.com/simpleinvoices2/simpleinvoices2/LICENSE GPL v3.0
 */

namespace SimpleInvoices\Biller;

use SimpleInvoices\Core\Db\ManagerInterface;

interface BillerManagerInterface extends ManagerInterface
{
    /**
     * Delete a biller.
     *
     * @param BillerInterface $biller
     */
    public function delete($biller);
    
    /**
     * Get all billers.
     *
     * @param bool $paginated
     * @return \Zend\Paginator\Paginator|\Zend\Db\ResultSet\ResultSet
     */
    public function getAllBillers($paginated = false);
    
    /**
     * Get a biller by the given ID.
     *
     * @param integer $id
     * @return BillerInterface|null
     */
    public function getBiller($id);
    
    /**
     * Save a biller.
     *
     * @param BillerInterface $biller
     */
    public function save(BillerInterface $biller);
}