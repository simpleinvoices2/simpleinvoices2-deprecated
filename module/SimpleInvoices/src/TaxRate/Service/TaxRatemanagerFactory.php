<?php
/**
 * @link      http://github.com/simpleinvoices2/simpleinvoices2
 * @copyright Copyright (c) 2016 Juan Pedro Gonzalez Gutierrez
 * @license   http://github.com/simpleinvoices2/simpleinvoices2/LICENSE GPL v3.0
 */
namespace SimpleInvoices\TaxRate\Service;

use Interop\Container\ContainerInterface;
use Zend\Db\Adapter\Adapter;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use SimpleInvoices\TaxRate\TaxRateManager;

class TaxRateManagerFactory implements FactoryInterface
{
    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string             $requestedName
     * @param  null|array         $options
     * @return TaxRateManager
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $adapter               = $container->get(Adapter::class);

        $taxRateManager = new TaxRateManager($adapter);
        $taxRateManager->setEventManager($container->get('SimpleInvoices\EventManager'));
        
        return $taxRateManager;
    }

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return TaxRateManager
     */
    public function createService(ServiceLocatorInterface $serviceManager)
    {
        return $this($serviceManager, TaxRateManager::class);
    }
}