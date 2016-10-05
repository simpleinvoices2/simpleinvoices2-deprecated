<?php
/**
 * @link      http://github.com/simpleinvoices2/simpleinvoices2
 * @copyright Copyright (c) 2016 Juan Pedro Gonzalez Gutierrez
 * @license   http://github.com/simpleinvoices2/simpleinvoices2/LICENSE GPL v3.0
 */

namespace SimpleInvoices;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;
use Zend\Session\Storage\SessionArrayStorage;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/dashboard',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'login' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/',
                    'defaults' => [
                        'controller' => Controller\AuthenticationController::class,
                        'action'     => 'login',
                    ],
                ],
            ],
            'logout' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/logout.html',
                    'defaults' => [
                        'controller' => Controller\AuthenticationController::class,
                        'action'     => 'logout',
                    ],
                ],
            ],
            'taxrates' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/tax-rates[/:action]',
                    'defaults' => [
                        'controller' => Controller\TaxRateController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'paymentmethods' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/payment-methods[/:action]',
                    'defaults' => [
                        'controller' => Controller\PaymentMethodController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'customers' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/customers[/:action]',
                    'defaults' => [
                        'controller' => Controller\CustomersController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'billers' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/billers[/:action]',
                    'defaults' => [
                        'controller' => Controller\BillersController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'navigation' => [
        'default' => [
            [
                'label' => 'Home',
                'route' => 'home',
            ],
            [
                'label' => 'People',
                'uri'   => '#',
                'pages' => [
                    [
                        'label' => 'Billers',
                        'route' => 'billers'
                    ],
                    [
                        'label' => 'Clients',
                        'route' => 'customers'
                    ],
                ],
            ],
        ],
        'secondary' => [
            [
                'label' => 'Settings',
                'uri'   => '#',
                'pages'=> [
                    [
                        'label' => 'Tax Rates',
                        'route' => 'taxrates',
                    ],
                    [
                        'label' => 'Payment Methods',
                        'route' => 'paymentmethods',
                    ],
                ],
            ],
            [
                'label' => 'Profile',
                'uri'   => '#',
                'pages' => [
                    [
                        'label' => 'Logout',
                        'route' => 'logout',
                    ]
                ],
            ]
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class          => InvokableFactory::class,
            Controller\AuthenticationController::class => Controller\Service\AuthenticationControllerFactory::class,
            Controller\TaxRateController::class        => Controller\Service\TaxRateControllerFactory::class,
            Controller\PaymentMethodController::class  => Controller\Service\PaymentMethodControllerFactory::class,
            Controller\CustomersController::class      => Controller\Service\CustomersControllerFactory::class,
            Controller\BillersController::class        => Controller\Service\BillersControllerFactory::class,
        ],
    ],
    'listeners' => [
        Authentication\Listener\AuthenticationRouteListener::class,
        MultiDomain\Listener\MultiDomainListener::class,
    ],
    'service_manager' => [
        'factories' => [
            \Zend\Navigation\Navigation::class                         => \Zend\Navigation\Service\DefaultNavigationFactory::class,
            Authentication\Listener\AuthenticationRouteListener::class => Authentication\Service\AuthenticationRouteListenerFactory::class,
            'SimpleInvoices\AuthenticationService'                     => Authentication\Service\AuthenticationServiceFactory::class,
            TaxRate\TaxRateManager::class                              => TaxRate\Service\TaxRateManagerFactory::class,
            PaymentMethod\PaymentMethodManager::class                  => PaymentMethod\Service\PaymentMethodManagerFactory::class,
            'SimpleInvoices\EventManager'                              => Core\Service\EventManagerFactory::class,
            MultiDomain\Listener\MultiDomainListener::class            => MultiDomain\Service\MultiDomainListenerFactory::class,
            Customer\CustomerManager::class                            => Customer\Service\CustomerManagerFactory::class,
            Biller\BillerManager::class                                => Biller\Service\BillerManagerFactory::class,
        ],
    ],
    'session_config' => [
        'remember_me_seconds' => 60*60*1,  // Session will expire in 1 hour.
        'name'                => 'si',     // Session name.
    ],
    'session_storage' => [
        'type' => SessionArrayStorage::class,
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'layout/empty'            => __DIR__ . '/../view/layout/empty.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
