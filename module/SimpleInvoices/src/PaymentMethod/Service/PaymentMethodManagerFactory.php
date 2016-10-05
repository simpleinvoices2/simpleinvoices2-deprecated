<?php
/**
 * @link      http://github.com/simpleinvoices2/simpleinvoices2
 * @copyright Copyright (c) 2016 Juan Pedro Gonzalez Gutierrez
 * @license   http://github.com/simpleinvoices2/simpleinvoices2/LICENSE GPL v3.0
 */
namespace SimpleInvoices\PaymentMethod\Service;

use Interop\Container\ContainerInterface;
use Zend\Db\Adapter\Adapter;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use SimpleInvoices\PaymentMethod\PaymentMethodManager;

class PaymentMethodManagerFactory implements FactoryInterface
{
    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string             $requestedName
     * @param  null|array         $options
     * @return PaymentMethodManager
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $adapter               = $container->get(Adapter::class);

        $paymentMethodManager = new PaymentMethodManager($adapter);
        $paymentMethodManager->setEventManager($container->get('SimpleInvoices\EventManager'));
        
        return $paymentMethodManager;
    }

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return PaymentMethodManager
     */
    public function createService(ServiceLocatorInterface $serviceManager)
    {
        return $this($serviceManager, PaymentMethodManager::class);
    }
}