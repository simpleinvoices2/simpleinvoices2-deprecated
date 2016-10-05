<?php
/**
 * @link      http://github.com/simpleinvoices2/simpleinvoices2
 * @copyright Copyright (c) 2016 Juan Pedro Gonzalez Gutierrez
 * @license   http://github.com/simpleinvoices2/simpleinvoices2/LICENSE GPL v3.0
 */

namespace SimpleInvoices\Core\Service;

use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\EventManager\EventManager;

/**
 * Creates an EventManager that will be used exculivelly for Simple Invoices.
 * 
 * @author Juan Pedro Gonzalez Gutierrez
 */
class EventManagerFactory implements FactoryInterface
{
    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string             $requestedName
     * @param  null|array         $options
     * @return object
     * @throws ServiceNotFoundException if unable to resolve the service.
     * @throws ServiceNotCreatedException if an exception is raised when
     *     creating a service.
     * @throws ContainerException if any other error occurs
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        if ($this->acceptsSharedManagerToConstructor()) {
            // zend-eventmanager v3
            return new EventManager(
                $container->has('SharedEventManager') ? $container->get('SharedEventManager') : null
            );
        }
        
        // zend-eventmanager v2
        $events = new EventManager();
        
        if ($container->has('SharedEventManager')) {
            $events->setSharedManager($container->get('SharedEventManager'));
        }
        
        return $events;
    }
    
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return $this($serviceLocator, 'SimpleInvoices\EventManager');
    }
    
    /**
     * Does the EventManager accept the shared manager to the constructor?
     *
     * In zend-eventmanager v3, the EventManager accepts the shared manager
     * instance to the constructor *only*, while in v2, it must be injected
     * via the setSharedManager() method.
     *
     * @return bool
     */
    private function acceptsSharedManagerToConstructor()
    {
        $r = new \ReflectionClass(EventManager::class);
        return ! $r->hasMethod('setSharedManager');
    }
}