<?php
/**
 * @link      http://github.com/simpleinvoices2/simpleinvoices2
 * @copyright Copyright (c) 2016 Juan Pedro Gonzalez Gutierrez
 * @license   http://github.com/simpleinvoices2/simpleinvoices2/LICENSE GPL v3.0
 */

namespace SimpleInvoices\Controller\Service;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use SimpleInvoices\Controller\PaymentMethodController;
use SimpleInvoices\PaymentMethod\PaymentMethodManager;

class PaymentMethodControllerFactory implements FactoryInterface 
{
    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string             $requestedName
     * @param  null|array         $options
     * @return PaymentMethodController
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $paymentMethodManager = $container->get(PaymentMethodManager::class);

        return new PaymentMethodController($paymentMethodManager);
    }

}