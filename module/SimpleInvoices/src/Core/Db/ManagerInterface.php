<?php
/**
 * @link      http://github.com/simpleinvoices2/simpleinvoices2
 * @copyright Copyright (c) 2016 Juan Pedro Gonzalez Gutierrez
 * @license   http://github.com/simpleinvoices2/simpleinvoices2/LICENSE GPL v3.0
 */

namespace SimpleInvoices\Core\Db;

use Zend\Db\Adapter\AdapterInterface;
use Zend\EventManager\EventManagerAwareInterface;

interface ManagerInterface extends EventManagerAwareInterface
{
    /**
     * Gets the database adapter.
     *
     * @return AdapterInterface
     */
    public function getAdapter();
}