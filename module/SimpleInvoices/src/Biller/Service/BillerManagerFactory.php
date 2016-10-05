<?php
/**
 * @link      http://github.com/simpleinvoices2/simpleinvoices2
 * @copyright Copyright (c) 2016 Juan Pedro Gonzalez Gutierrez
 * @license   http://github.com/simpleinvoices2/simpleinvoices2/LICENSE GPL v3.0
 */
namespace SimpleInvoices\Biller\Service;

use Interop\Container\ContainerInterface;
use Zend\Db\Adapter\Adapter;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use SimpleInvoices\Biller\BillerManager;
use SimpleInvoices\Biller\BillerManagerInterface;

class BillerManagerFactory implements FactoryInterface
{
    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string             $requestedName
     * @param  null|array         $options
     * @return BillerManagerInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $adapter         = $container->get(Adapter::class);

        $billerManager = new BillerManager($adapter);
        $billerManager->setEventManager($container->get('SimpleInvoices\EventManager'));

        return $billerManager;
    }

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return BillerManagerInterface
     */
    public function createService(ServiceLocatorInterface $serviceManager)
    {
        return $this($serviceManager, BillerManager::class);
    }
}