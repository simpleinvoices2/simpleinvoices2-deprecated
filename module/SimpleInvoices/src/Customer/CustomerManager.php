<?php
/**
 * @link      http://github.com/simpleinvoices2/simpleinvoices2
 * @copyright Copyright (c) 2016 Juan Pedro Gonzalez Gutierrez
 * @license   http://github.com/simpleinvoices2/simpleinvoices2/LICENSE GPL v3.0
 */

namespace SimpleInvoices\Customer;

use Zend\Db\Adapter\AdapterInterface;
use SimpleInvoices\Core\EventManager\SqlEvent;
use Zend\EventManager\EventManagerInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Delete;
use SimpleInvoices\Core\Db\AbstractManager;
use Zend\Db\Sql\Update;
use Zend\Db\Sql\Insert;

class CustomerManager extends AbstractManager implements CustomerManagerInterface
{    
    /** 
     * @var string
     */
    protected $table = 'si_customers';
    
    public function __construct(AdapterInterface $adapter, $table = 'si_customers')
    {
        parent::__construct($adapter, new Customer());

        $this->table = $table;
    }
    
    /**
     * Delete a customer.
     * 
     * @param CustomerInterface $customer
     */
    public function delete($customer)
    {
        if ($customer instanceof CustomerInterface) {
            $customer_id = $customer->getId();
        } else {
            $customer_id = (int) $customer;
        }
    
        $delete = new Delete($this->table);
        $delete->where([
            'id'    => $customer_id,
        ]);
    
        return $this->executeDelete($delete);
    }
    
    /**
     * Get all customers.
     *
     * @param bool $paginated
     * @return \Zend\Paginator\Paginator|\Zend\Db\ResultSet\ResultSet
     */
    public function getAllCustomers($paginated = false)
    {
        $select    = new Select($this->table);
        $select->order('name');
        
        return $this->executeSelect($select, $paginated);
    }
    
    /**
     * Get a customer by the given ID.
     * 
     * @param integer $id
     * @return CustomerInterface|null
     */
    public function getCustomer($id)
    {
        $select    = new Select($this->table);
        $select->where([
            'id'    => $id,
        ]);
    
        return $this->executeSelectOne($select);
    }
    
    /**
     * Save a customer.
     * 
     * @param CustomerInterface $customer
     */
    public function save(CustomerInterface $customer)
    {
        $id = (int) $customer->getId();
        $data = [
            'name'            => $customer->getName(),
            'street_address'  => $customer->getStreetAddress(),
            'street_address2' => $customer->getStreetAddress2(),
            'city'            => $customer->getCity(),
            'state'           => $customer->getState(),
            'zip_code'        => $customer->getZipCode(),
            'country'         => $customer->getCountry(),
            'phone'           => $customer->getPhone(),
            'mobile_phone'    => $customer->getMobilePhone(),
            'fax'             => $customer->getFax(),
            'email'           => $customer->getEmailAddress(),
            'notes'           => $customer->getComments(),
            'enabled'         => $customer->isEnabled(),
        ];
    
        if ($id === 0) {
            $insert = new Insert($this->table);
            $insert->values($data);
    
            $new_id = $this->executeInsert($insert);
            
            if ($new_id > 0) {
                $data['id'] = $new_id;
                $customer->exchangeArray($data);
                
                return true;
            }
        } else {
            $update = new Update($this->table);
            $update->set($data);
            $update->where([
                'id'    => $id,
            ]);
    
            return $this->executeUpdate($update);
        }
    
        return false;
    }
    
}