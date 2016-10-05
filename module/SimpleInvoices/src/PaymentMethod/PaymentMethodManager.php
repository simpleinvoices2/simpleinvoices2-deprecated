<?php
/**
 * @link      http://github.com/simpleinvoices2/simpleinvoices2
 * @copyright Copyright (c) 2016 Juan Pedro Gonzalez Gutierrez
 * @license   http://github.com/simpleinvoices2/simpleinvoices2/LICENSE GPL v3.0
 */

namespace SimpleInvoices\PaymentMethod;

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

class PaymentMethodManager implements PaymentMethodManagerInterface
{
    /**
     * @var AdapterInterface
     */
    protected $adapter;
    
    /**
     * @var PaymentMethodEvent
     */
    protected $event;
    
    /**
     * @var EventManagerInterface
     */
    protected $events;
    
    /**
     * @var PaymentMethodInterface
     */
    protected $paymentMethodPrototype;
    
    /**
     * @var string|TableIdentifier
     */
    protected $table = 'si_payment_types';
    
    public function __construct(AdapterInterface $adapter, $table = 'si_payment_types')
    {
        $this->adapter                = $adapter;
        $this->table                  = $table;
        $this->paymentMethodPrototype = new PaymentMethod();
    }
    
    public function delete($paymentMethod)
    {
        if ($paymentMethod instanceof PaymentMethodInterface) {
            $paymentMethod_id = $paymentMethod->getId();
        } else {
            $paymentMethod_id = (int) $paymentMethod;
        }
    
        $sql = new Sql($this->adapter);
    
        $delete = new Delete($this->table);
        $delete->where([
            'pt_id'    => $paymentMethod_id,
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
    
    public function getAllPaymentMethods($paginated = false)
    {
        $select    = new Select($this->table);
        $select->order('pt_description');
        
        // Create a new resultset based on paymentmethod entity
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype($this->paymentMethodPrototype);
        
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
    
    public function getPaymentMethod($id)
    {
        $select    = new Select($this->table);
        $select->where([
            'pt_id'    => $id,
        ]);
        $select->order('pt_description');
    
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
                $paymentMethod = clone $this->paymentMethodPrototype;
                $paymentMethod->exchangeArray($data);
                return $paymentMethod;
            }
        }
    
        return null;
    }
    
    /**
     * Get the payment method prototype class.
     *
     * @return PaymentMethodInterface
     */
    public function getPaymentMethodPrototype()
    {
        if (!$this->paymentMethodPrototype instanceof PaymentMethodInterface) {
            $this->paymentMethodPrototype = new PaymentMethod();
        }
        
        return clone $this->paymentMethodPrototype;
    }
    
    public function save(PaymentMethodInterface $paymentMethod)
    {
        $affectedRpows    = 0;
        $paymentMethod_id = (int) $paymentMethod->getId();
        $data = [
            'pt_description' => $paymentMethod->getDescription(),
            'pt_enabled'     => $paymentMethod->isEnabled(),
        ];
    
        $sql = new Sql($this->adapter);
    
        if ($paymentMethod_id === 0) {
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
                $data['pt_id'] = $this->adapter->getDriver()->getConnection()->getLastGeneratedValue();
                $paymentMethod->exchangeArray($data);
            }
        } else {
            $update = new Update($this->table);
            $update->set($data);
            $update->where([
                'pt_id'     => $paymentMethod_id,
            ]);
    
            // Trigger the event before performing the SQL query.
            $event = $this->getEvent();
            $event->setName(SqlEvent::EVENT_QUERY_UPDATE);
            $event->setParams(['update' => $update]);
            $this->events->triggerEvent($event);
    
            $statement = $sql->prepareStatementForSqlObject($update);
            $result    = $statement->execute();
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