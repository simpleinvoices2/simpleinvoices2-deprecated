<?php
/**
 * @link      http://github.com/simpleinvoices2/simpleinvoices2
 * @copyright Copyright (c) 2016 Juan Pedro Gonzalez Gutierrez
 * @license   http://github.com/simpleinvoices2/simpleinvoices2/LICENSE GPL v3.0
 */

namespace SimpleInvoices\Authentication\Service;

use Interop\Container\ContainerInterface;
use Zend\Authentication\Adapter\DbTable;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session;
use Zend\Db\Adapter\Adapter;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AuthenticationServiceFactory implements FactoryInterface
{
    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string             $requestedName
     * @param  null|array         $options
     * @return AuthenticationService
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $adapter               = $container->get(Adapter::class);
        $dbTable               = new DbTable($adapter, 'si_user', 'email', 'password', 'MD5(?) AND enabled=1');
        $authenticationStorage = new Session();
        $authenticationService = new AuthenticationService($authenticationStorage, $dbTable);

        return $authenticationService;
    }

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return AuthenticationService
     */
    public function createService(ServiceLocatorInterface $serviceManager)
    {
        return $this($serviceManager, 'SimpleInvoices\AuthenticationService');
    }
}