<?php
/**
 * @link      http://github.com/simpleinvoices2/simpleinvoices2
 * @copyright Copyright (c) 2016 Juan Pedro Gonzalez Gutierrez
 * @license   http://github.com/simpleinvoices2/simpleinvoices2/LICENSE GPL v3.0
 */

namespace SimpleInvoices\TaxRate;

use Zend\Db\Adapter\AdapterInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Db\Sql\TableIdentifier;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Update;
use Zend\Db\Sql\Delete;
use SimpleInvoices\Core\EventManager\SqlEvent;

class TaxRateManager implements TaxRateManagerInterface
{
    /**
     * @var AdapterInterface
     */
    protected $adapter;
    
    /**
     * @var SqlEvent
     */
    protected $event;
    
    /**
     * @var EventManagerInterface
     */
    protected $events;
    
    /**
     * @var TaxRateInterface
     */
    protected $taxRatePrototype;
    
    /**
     * @var string|TableIdentifier
     */
    protected $table = 'si_tax';
    
    public function __construct(AdapterInterface $adapter, $table = 'si_tax')
    {
        $this->adapter          = $adapter;
        $this->table            = $table;
        $this->taxRatePrototype = new TaxRate();
    }
    
    public function delete($tax)
    {   
        if ($tax instanceof TaxRateInterface) {
            $tax_id = $tax->getId();
        } else {
            $tax_id = (int) $tax;
        }
        
        $sql = new Sql($this->adapter);
        
        $delete = new Delete($this->table);
        $delete->where([
            'tax_id'    => $tax_id,
        ]);
        
        // Trigger the vent before performing the SQL query.
        $event = $this->getEvent();
        $event->setName(SqlEvent::EVENT_QUERY_DELETE);
        $event->setParams(['delete' => $delete]);
        $this->events->triggerEvent($event);
        
        $statement = $sql->prepareStatementForSqlObject($delete);
        $result    = $statement->execute();
        
        if ($result->getAffectedRows() === 1) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Get all tax rates.
     * 
     * @param bool $paginated
     * @return \Zend\Paginator\Paginator|\Zend\Db\ResultSet\ResultSet
     */
    public function getAllTaxes($paginated = false)
    {
        $select    = new Select($this->table);
        $select->order('tax_description');
        
        // Create a new resultset based on taxrate entity
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype($this->taxRatePrototype);
        
        // Trigger the vent before performing the SQL query.
        $event = $this->getEvent();
        $event->setName(SqlEvent::EVENT_QUERY_SELECT);
        $event->setParams(['select' => $select]);
        $this->events->triggerEvent($event);
        
        if ($paginated) {
            $paginatorAdapter = new DbSelect($select, $this->adapter, $resultSetPrototype);
            $paginator        = new Paginator($paginatorAdapter);
            
            return $paginator;
        } else {
            $sql       = new Sql($this->adapter);
            $statement = $sql->prepareStatementForSqlObject($select);
            $result    = $statement->execute();
            
            $resultSetPrototype->initialize($result);
            
            return $resultSetPrototype;
        }
    }
    
    /**
     * Get the event.
     * 
     * @return \SimpleInvoices\Core\EventManager\SqlEvent
     */
    public function getEvent()
    {
        if (!$this->event instanceof SqlEvent) {
            $this->event = new SqlEvent();
            $this->event->setTarget($this);
        }
        
        return $this->event;
    }
    
    /**
     * Retrieve the event manager
     *
     * Lazy-loads an EventManager instance if none registered.
     *
     * @return EventManagerInterface
     */
    public function getEventManager()
    {
        return $this->events;
    }
    
    public function getTax($id)
    {    
        $select    = new Select($this->table);
        $select->where([
            'tax_id'    => $id,
        ]);
        $select->order('tax_description');
        
        $sql       = new Sql($this->adapter);
        
        // Trigger the event before performing the SQL query.
        $event = $this->getEvent();
        $event->setName(SqlEvent::EVENT_QUERY_SELECT);
        $event->setParams(['select' => $select]);
        $this->events->triggerEvent($event);
        
        $statement = $sql->prepareStatementForSqlObject($select);
        $result    = $statement->execute();
        
        if ($result instanceof ResultInterface && $result->isQueryResult()) {
            $data = $result->current();
            
            if ($data) {
                $tax = clone $this->taxRatePrototype;
                $tax->exchangeArray($data);
                return $tax;
            }
        }
        
        return null;
    }
    
    /**
     * Get the tax rate prototype class.
     * 
     * @return TaxRateInterface
     */
    public function getTaxRatePrototype()
    {
        if (!$this->taxRatePrototype instanceof TaxRateInterface) {
            $this->taxRatePrototype = new TaxRate();
        }
        
        return clone $this->taxRatePrototype;
    }
    
    public function save(TaxRateInterface $tax)
    {    
        $affectedRpows = 0;
        $tax_id        = (int) $tax->getId();
        $data = [
            'tax_description' => $tax->getDescription(),
            'tax_percentage'  => $tax->getPercentage(),
            'type'            => $tax->getType(),
            'tax_enabled'     => $tax->isEnabled(),
        ];
        
        $sql = new Sql($this->adapter);
        
        if ($tax_id === 0) {            
            $insert = new Insert($this->table);
            $insert->values($data);
            
            // Trigger the event before performing the SQL query.
            $event = $this->getEvent();
            $event->setName(SqlEvent::EVENT_QUERY_INSERT);
            $event->setParams(['insert' => $insert]);
            $this->events->triggerEvent($event);
            
            $statement = $sql->prepareStatementForSqlObject($insert);
            $result    = $statement->execute();
            
            if ($result->getAffectedRows() === 1) {
                $data['tax_id'] = $this->adapter->getDriver()->getConnection()->getLastGeneratedValue();
                $tax->exchangeArray($data);
            }
        } else {
            $update = new Update($this->table);
            $update->set($data);
            $update->where([
                'tax_id'    => $tax_id,
            ]);
            
            // Trigger the event before performing the SQL query.
            $event = $this->getEvent();
            $event->setName(SqlEvent::EVENT_QUERY_UPDATE);
            $event->setParams(['update' => $update]);
            $this->events->triggerEvent($event);
            
            $statement = $sql->prepareStatementForSqlObject($update);
            $result = $statement->execute();
        }
        
        if ($result->getAffectedRows() === 1) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Inject an EventManager instance
     *
     * @param  EventManagerInterface $eventManager
     * @return void
     */
    public function setEventManager(EventManagerInterface $eventManager)
    {
        $this->events = $eventManager;
    }
}