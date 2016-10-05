<?php
/**
 * @link      http://github.com/simpleinvoices2/simpleinvoices2
 * @copyright Copyright (c) 2016 Juan Pedro Gonzalez Gutierrez
 * @license   http://github.com/simpleinvoices2/simpleinvoices2/LICENSE GPL v3.0
 */
namespace SimpleInvoices\Customer\Service;

use Interop\Container\ContainerInterface;
use Zend\Db\Adapter\Adapter;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use SimpleInvoices\Customer\CustomerManager;
use SimpleInvoices\Customer\CustomerManagerInterface;

class CustomerManagerFactory implements FactoryInterface
{
    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string             $requestedName
     * @param  null|array         $options
     * @return CustomerManagerInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $adapter         = $container->get(Adapter::class);

        $customerManager = new CustomerManager($adapter);
        $customerManager->setEventManager($container->get('SimpleInvoices\EventManager'));

        return $customerManager;
    }

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return CustomerManagerInterface
     */
    public function createService(ServiceLocatorInterface $serviceManager)
    {
        return $this($serviceManager, CustomerManager::class);
    }
}