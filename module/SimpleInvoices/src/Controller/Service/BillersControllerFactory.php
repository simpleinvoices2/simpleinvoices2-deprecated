<?php
/**
 * @link      http://github.com/simpleinvoices2/simpleinvoices2
 * @copyright Copyright (c) 2016 Juan Pedro Gonzalez Gutierrez
 * @license   http://github.com/simpleinvoices2/simpleinvoices2/LICENSE GPL v3.0
 */

namespace SimpleInvoices\Controller\Service;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use SimpleInvoices\Biller\BillerManager;
use SimpleInvoices\Controller\BillersController;

class BillersControllerFactory implements FactoryInterface 
{
    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string             $requestedName
     * @param  null|array         $options
     * @return CustomersController
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $billerManager = $container->get(BillerManager::class);

        return new BillersController($billerManager);
    }

}