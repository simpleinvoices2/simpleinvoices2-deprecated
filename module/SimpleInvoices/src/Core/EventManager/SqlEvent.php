<?php
/**
 * @link      http://github.com/simpleinvoices2/simpleinvoices2
 * @copyright Copyright (c) 2016 Juan Pedro Gonzalez Gutierrez
 * @license   http://github.com/simpleinvoices2/simpleinvoices2/LICENSE GPL v3.0
 */

namespace SimpleInvoices\Core\EventManager;

use Zend\EventManager\EventInterface;

class SqlEvent implements EventInterface
{
    const EVENT_QUERY_DELETE = 'sqlQueryDelete';
    const EVENT_QUERY_INSERT = 'sqlQueryInsert';
    const EVENT_QUERY_UPDATE = 'sqlQueryUpdate';
    const EVENT_QUERY_SELECT = 'sqlQuerySelect';
    
    /**
     * @var PaymentMethodManagerInterface
     */
    protected $target = null;
    
    /**
     * @var null
     */
    protected $name = null;
    
    /**
     * @var array|\ArrayAccess
     */
    protected $params = [];
    
    /**
     * Get event name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Get target/context from which event was triggered
     *
     * @return null|string|object
     */
    public function getTarget()
    {
        return $this->target;
    }
    
    /**
     * Get parameters passed to the event
     *
     * @return array|\ArrayAccess
     */
    public function getParams()
    {
        return $this->params;
    }
    
    /**
     * Get a single parameter by name
     *
     * @param  string $name
     * @param  mixed $default Default value to return if parameter does not exist
     * @return mixed
     */
    public function getParam($name, $default = null)
    {
        return (isset($this->params[$name]) ? $this->params[$name] : $default);
    }
    
    /**
     * Set the event name
     *
     * @param  string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    
    /**
     * Set the event target/context
     *
     * @param  null|string|object $target
     * @return void
     */
    public function setTarget($target)
    {
        $this->target = $target;
    }
    
    /**
     * Set event parameters
     *
     * @param  string $params
     * @return void
     */
    public function setParams($params)
    {
        $this->params = $params;
    }
    
    /**
     * Set a single parameter by key
     *
     * @param  string $name
     * @param  mixed $value
     * @return void
     */
    public function setParam($name, $value)
    {
        $this->params[$name] = $value;
    }
    
    /**
     * Indicate whether or not the parent EventManagerInterface should stop propagating events
     *
     * @param  bool $flag
     * @return void
     */
    public function stopPropagation($flag = true)
    {
        return;
    }
    
    /**
     * Has this event indicated event propagation should stop?
     *
     * @return bool
     */
    public function propagationIsStopped()
    {
        return false;
    }
}