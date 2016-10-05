<?php
/**
 * @link      http://github.com/simpleinvoices2/simpleinvoices2
 * @copyright Copyright (c) 2016 Juan Pedro Gonzalez Gutierrez
 * @license   http://github.com/simpleinvoices2/simpleinvoices2/LICENSE GPL v3.0
 */

namespace SimpleInvoices\Core\Db;

use Zend\EventManager\EventManagerInterface;
use SimpleInvoices\Core\EventManager\SqlEvent;
use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Delete;
use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\ResultSet\ResultSetInterface;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Update;
use Zend\EventManager\EventManager;
use Zend\Db\Adapter\Driver\ResultInterface;

abstract class AbstractManager implements ManagerInterface
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
     * @var mixed
     */
    protected $objectPrototype;
    
    /**
     * Constructor.
     * 
     * @param AdapterInterface $adapter
     * @param object $objectPrototype
     */
    public function __construct(AdapterInterface $adapter, $objectPrototype)
    {
        $this->adapter         = $adapter;
        $this->objectPrototype = $objectPrototype;
    }
    
    /**
     * Execute a delete SQL query.
     * 
     * @param Delete $delete
     * @return bool
     */
    protected function executeDelete(Delete $delete)
    {
        $sql    = new Sql($this->adapter);
        
        // Trigger the event before performing the SQL query.
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
     * Execute a select SQL query.
     * 
     * @param Select $select
     * @param bool $paginated
     * @return ResultSetInterface|Paginator
     */
    protected function executeSelect(Select $select, $paginated = false)
    {
        // Create a new resultset based on taxrate entity
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype($this->objectPrototype);
        
        // Trigger the vent before performing the SQL query.
        $event = $this->getEvent();
        $event->setName(SqlEvent::EVENT_QUERY_SELECT);
        $event->setParams(['select' => $select]);
        $this->getEventManager()->triggerEvent($event);
        
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
     * Execute a select SQL query which should only return one single result.
     * 
     * @param Select $select
     * @return null|object
     */
    protected function executeSelectOne(Select $select)
    {
        $sql       = new Sql($this->adapter);
        
        // Trigger the event before performing the SQL query.
        $event = $this->getEvent();
        $event->setName(SqlEvent::EVENT_QUERY_SELECT);
        $event->setParams(['select' => $select]);
        $this->getEventManager()->triggerEvent($event);
        
        $statement = $sql->prepareStatementForSqlObject($select);
        $result    = $statement->execute();
        
        if ($result instanceof ResultInterface && $result->isQueryResult()) {
            $data = $result->current();
        
            if ($data) {
                $obj = clone $this->objectPrototype;
                if (method_exists($obj, 'exchangeArray')){
                    $obj->exchangeArray($data);
                }
                return $obj;
            }
        }
        
        return null;
    }
    
    /**
     * Execute an insert SQL query.
     * 
     * @param Insert $insert
     * @return int Returns the last inserted ID or 0 if something went wrong.
     */
    protected function executeInsert(Insert $insert)
    {
        $sql = new Sql($this->adapter);
        
        // Trigger the event before performing the SQL query.
        $event = $this->getEvent();
        $event->setName(SqlEvent::EVENT_QUERY_INSERT);
        $event->setParams(['insert' => $insert]);
        $this->getEventManager()->triggerEvent($event);
        
        $statement = $sql->prepareStatementForSqlObject($insert);
        $result    = $statement->execute();
        
        if ($result->getAffectedRows() === 1) {
            return $this->adapter->getDriver()->getConnection()->getLastGeneratedValue();
        }
        
        return 0;
    }
    
    /**
     * Execute an update SQL query.
     * 
     * @param Update $update
     * @return bool
     */
    protected function executeUpdate(Update $update)
    {
        $sql = new Sql($this->adapter);
        
        // Trigger the event before performing the SQL query.
        $event = $this->getEvent();
        $event->setName(SqlEvent::EVENT_QUERY_UPDATE);
        $event->setParams(['update' => $update]);
        $this->getEventManager()->triggerEvent($event);
        
        $statement = $sql->prepareStatementForSqlObject($update);
        $result = $statement->execute();
        
        if ($result->getAffectedRows() === 1) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Gets the database adapter.
     * 
     * @return AdapterInterface
     */
    public function getAdapter()
    {
        return $this->adapter;
    }
    
    /**
     * Get the event.
     * 
     * @return 
     */
    protected function getEvent()
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
    
    /**
     * Return the object prototype.
     * 
     * @return mixed
     */
    public function getObjectPrototype()
    {
        return clone $this->objectPrototype;
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