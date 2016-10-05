<?php
/**
 * @link      http://github.com/simpleinvoices2/simpleinvoices2
 * @copyright Copyright (c) 2016 Juan Pedro Gonzalez Gutierrez
 * @license   http://github.com/simpleinvoices2/simpleinvoices2/LICENSE GPL v3.0
 */

namespace SimpleInvoices\Controller\Service;

use Interop\Container\ContainerInterface;
use SimpleInvoices\Controller\AuthenticationController;
use Zend\Db\Adapter\Adapter;
use Zend\ServiceManager\Factory\FactoryInterface;

class AuthenticationControllerFactory implements FactoryInterface 
{
    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string             $requestedName
     * @param  null|array         $options
     * @return AuthenticationController
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $authenticationService = $container->get('SimpleInvoices\AuthenticationService');

        return new AuthenticationController($authenticationService, $container->get(Adapter::class));
    }

}