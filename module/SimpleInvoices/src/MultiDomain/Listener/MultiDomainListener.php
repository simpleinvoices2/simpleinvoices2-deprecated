<?php
/**
 * @link      http://github.com/simpleinvoices2/simpleinvoices2
 * @copyright Copyright (c) 2016 Juan Pedro Gonzalez Gutierrez
 * @license   http://github.com/simpleinvoices2/simpleinvoices2/LICENSE GPL v3.0
 */

namespace SimpleInvoices\MultiDomain\Listener;

use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use SimpleInvoices\Core\EventManager\SqlEvent;
use Zend\EventManager\EventInterface;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Update;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Delete;
use Zend\Session\Container as SessionContainer;

class MultiDomainListener extends AbstractListenerAggregate
{
    /**
     * Attach one or more listeners
     *
     * Implementors may add an optional $priority argument; the EventManager
     * implementation will pass this to the aggregate.
     *
     * @param EventManagerInterface $events
     * @param int                   $priority
     * @return void
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach('bootstrap', [$this, 'initSession'], 9998);
        $this->listeners[] = $events->attach(SqlEvent::EVENT_QUERY_DELETE, [$this, 'onDeleteRecord'], $priority);
        $this->listeners[] = $events->attach(SqlEvent::EVENT_QUERY_INSERT, [$this, 'onInsertRecord'], $priority);
        $this->listeners[] = $events->attach(SqlEvent::EVENT_QUERY_UPDATE, [$this, 'onUpdateRecord'], $priority);
        $this->listeners[] = $events->attach(SqlEvent::EVENT_QUERY_SELECT, [$this, 'onSelectRecord'], $priority);
    }
    
    /**
     * Get the domain id.
     * 
     * @return int The domain ID.
     */
    protected function getDomainId()
    {
        $session = new SessionContainer('si_auth');
        if (isset($session->domain_id)) {
            return $session->domain_id;
        }
        
        // Default domain is 1
        return 1;
    }
    
    public function initSession(EventInterface $event)
    {
        $sessionContainer = new SessionContainer('si_auth');
        
        // Initialize a guest session if necessary
        if (!isset($sessionContainer->domain_id)) {
            $sessionContainer->domain_id = 1;
            $sessionContainer->domain    = 'default';
        }    
    }
    
    /**
     * Handle the sqlQueryDelete event
     *
     * @param EventInterface $event
     * @return void
     */
    public function onDeleteRecord(EventInterface $event)
    {
        if (!$event instanceof SqlEvent) {
            return;
        }
        
        $delete = $event->getParam('delete', null);
        if (!$delete instanceof Delete) {
            return;
        }
        
        $delete->where([
            'domain_id' => $this->getDomainId(),
        ]);
    }
    
    /**
     * Handle the sqlQueryInsert event
     *
     * @param EventInterface $event
     * @return void
     */
    public function onInsertRecord(EventInterface $event)
    {
        if (!$event instanceof SqlEvent) {
            return;
        }
        
        $insert = $event->getParam('insert', null);
        if (!$insert instanceof Insert) {
            return;
        }
        
        $insert->values([
            'domain_id' => $this->getDomainId(),
        ], Insert::VALUES_MERGE);
    }
    
    /**
     * Handle the sqlQueryUpdate event
     *
     * @param EventInterface $event
     * @return void
     */
    public function onUpdateRecord(EventInterface $event)
    {
        if (!$event instanceof SqlEvent) {
            return;
        }
        
        $update = $event->getParam('update', null);
        if (!$update instanceof Update) {
            return;
        }
        
        $update->where([
            'domain_id' => $this->getDomainId(),
        ]);
    }
    
    /**
     * Handle the sqlQuerySelect event
     *
     * @param EventInterface $event
     * @return void
     */
    public function onSelectRecord(EventInterface $event)
    {
        if (!$event instanceof SqlEvent) {
            return;
        }
        
        $select = $event->getParam('select', null);
        if (!$select instanceof Select) {
            return;
        }
        
        $select->where([
           'domain_id' => $this->getDomainId(), 
        ]);
    }
}