<?php
/**
 * @link      http://github.com/simpleinvoices2/simpleinvoices2
 * @copyright Copyright (c) 2016 Juan Pedro Gonzalez Gutierrez
 * @license   http://github.com/simpleinvoices2/simpleinvoices2/LICENSE GPL v3.0
 */

namespace SimpleInvoices\Biller;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Paginator\Paginator;
use Zend\Db\Sql\Delete;
use SimpleInvoices\Core\Db\AbstractManager;
use Zend\Db\Sql\Update;
use Zend\Db\Sql\Insert;

class BillerManager extends AbstractManager implements BillerManagerInterface
{    
    /** 
     * @var string
     */
    protected $table = 'si_biller';
    
    public function __construct(AdapterInterface $adapter, $table = 'si_biller')
    {
        parent::__construct($adapter, new Biller());

        $this->table = $table;
    }
    
    /**
     * Delete a biller.
     * 
     * @param BillerInterface $biller
     */
    public function delete($biller)
    {
        if ($biller instanceof BillerInterface) {
            $biller_id = $biller->getId();
        } else {
            $biller_id = (int) $biller;
        }
    
        $delete = new Delete($this->table);
        $delete->where([
            'id'    => $biller_id,
        ]);
    
        return $this->executeDelete($delete);
    }
    
    /**
     * Get all billers.
     *
     * @param bool $paginated
     * @return \Zend\Paginator\Paginator|\Zend\Db\ResultSet\ResultSet
     */
    public function getAllBillers($paginated = false)
    {
        $select    = new Select($this->table);
        $select->order('name');
        
        return $this->executeSelect($select, $paginated);
    }
    
    /**
     * Get a biller by the given ID.
     * 
     * @param integer $id
     * @return BillerInterface|null
     */
    public function getBiller($id)
    {
        $select    = new Select($this->table);
        $select->where([
            'id'    => $id,
        ]);
    
        return $this->executeSelectOne($select);
    }
    
    /**
     * Save a biller.
     * 
     * @param BillerInterface $biller
     */
    public function save(BillerInterface $biller)
    {
        $id = (int) $biller->getId();
        $data = [
            'name'            => $biller->getName(),
            'street_address'  => $biller->getStreetAddress(),
            'street_address2' => $biller->getStreetAddress2(),
            'city'            => $biller->getCity(),
            'state'           => $biller->getState(),
            'zip_code'        => $biller->getZipCode(),
            'country'         => $biller->getCountry(),
            'phone'           => $biller->getPhone(),
            'mobile_phone'    => $biller->getMobilePhone(),
            'fax'             => $biller->getFax(),
            'email'           => $biller->getEmailAddress(),
            'notes'           => $biller->getComments(),
            'enabled'         => $biller->isEnabled(),
        ];
    
        if ($id === 0) {
            $insert = new Insert($this->table);
            $insert->values($data);
    
            $new_id = $this->executeInsert($insert);
            
            if ($new_id > 0) {
                $data['id'] = $new_id;
                $biller->exchangeArray($data);
                
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