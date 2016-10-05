<?php
/**
 * @link      http://github.com/simpleinvoices2/simpleinvoices2
 * @copyright Copyright (c) 2016 Juan Pedro Gonzalez Gutierrez
 * @license   http://github.com/simpleinvoices2/simpleinvoices2/LICENSE GPL v3.0
 */

namespace SimpleInvoices\Customer;

use SimpleInvoices\Core\Db\ManagerInterface;

interface CustomerManagerInterface extends ManagerInterface
{
    /**
     * Delete a customer.
     *
     * @param CustomerInterface $customer
     */
    public function delete($customer);
    
    /**
     * Get all customers.
     *
     * @param bool $paginated
     * @return \Zend\Paginator\Paginator|\Zend\Db\ResultSet\ResultSet
     */
    public function getAllCustomers($paginated = false);
    
    /**
     * Get a customer by the given ID.
     *
     * @param integer $id
     * @return CustomerInterface|null
     */
    public function getCustomer($id);
    
    /**
     * Save a customer.
     *
     * @param CustomerInterface $customer
     */
    public function save(CustomerInterface $customer);
}