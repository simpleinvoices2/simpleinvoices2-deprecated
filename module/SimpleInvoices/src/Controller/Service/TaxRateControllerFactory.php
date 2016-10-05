<?php
/**
 * @link      http://github.com/simpleinvoices2/simpleinvoices2
 * @copyright Copyright (c) 2016 Juan Pedro Gonzalez Gutierrez
 * @license   http://github.com/simpleinvoices2/simpleinvoices2/LICENSE GPL v3.0
 */

namespace SimpleInvoices\Controller\Service;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use SimpleInvoices\TaxRate\TaxRateManager;
use SimpleInvoices\Controller\TaxRateController;

class TaxRateControllerFactory implements FactoryInterface 
{
    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string             $requestedName
     * @param  null|array         $options
     * @return TaxRateController
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $taxRateManager = $container->get(TaxRateManager::class);

        return new TaxRateController($taxRateManager);
    }

}