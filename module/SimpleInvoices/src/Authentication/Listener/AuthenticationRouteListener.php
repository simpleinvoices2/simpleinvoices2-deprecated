<?php
/**
 * @link      http://github.com/simpleinvoices2/simpleinvoices2
 * @copyright Copyright (c) 2016 Juan Pedro Gonzalez Gutierrez
 * @license   http://github.com/simpleinvoices2/simpleinvoices2/LICENSE GPL v3.0
 */

namespace SimpleInvoices\Authentication\Listener;

use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\MvcEvent;
use Zend\Session\SessionManager;
use Zend\Session\Container as SessionContainer;
use Zend\Mvc\Controller\AbstractController;

/**
 * Based on https://github.com/zfcampus/zf-mvc-auth/blob/master/src/MvcRouteListener.php
 */
class AuthenticationRouteListener extends AbstractListenerAggregate implements EventManagerAwareInterface 
{
    /**
     * @var EventManagerInterface
     */
    protected $events;

    public function __construct(EventManagerInterface $events)
    {
        $this->setEventManager($events);
    }

    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(MvcEvent::EVENT_BOOTSTRAP, [$this, 'initSession'], 9999);
        $this->listeners[] = $events->attach(MvcEvent::EVENT_ROUTE, [$this, 'authentication'], -50);
        $this->listeners[] = $events->attach(MvcEvent::EVENT_ROUTE, [$this, 'authorization'], -600);
        $this->listeners[] = $events->attach(MvcEvent::EVENT_ROUTE, [$this, 'authorizationPost'], -601);
        
        // Change layout if not authenticated.
        $this->listeners[] = $events->attach(MvcEvent::EVENT_DISPATCH, [$this, 'setLayout'], 1);
        $this->listeners[] = $events->attach(MvcEvent::EVENT_DISPATCH_ERROR, [$this, 'setLayout'], 1);
    }

    /**
     * Listen to the 'route' event and check for authentication.
     * 
     * @param MvcEvent $event
     * @return void|\Zend\Stdlib\ResponseInterface
     */
    public function authentication(MvcEvent $event)
    {
    	$match = $event->getRouteMatch();
        if (! $match) {
            // We cannot do anything without a resolved route.
            return;
        }

        if ($match->getMatchedRouteName() === 'login') {
            // login is allowed always
            return;
        }
        
        // Get AuthenticationService and do the verification.
        $services    = $event->getApplication()->getServiceManager();
        $authService = $services->get('SimpleInvoices\AuthenticationService');

        // If user has an identity.
        if ($authService->hasIdentity()) {
            return;
        }
        
        // Redirect to the user login page
        $router   = $event->getRouter();
        $url      = $router->assemble([], ['name' => 'login']);

        $response = $event->getResponse();
        $response->getHeaders()->addHeaderLine('Location', $url);
        $response->setStatusCode(302);

        return $response;
    }

    public function authorization(MvcEvent $event)
    {

    }

    public function authorizationPost(MvcEvent $event)
    {

    }

    /**
     * Listen to the "dispatch" and "dispatch.error" events and determine which
     * layout should be used.
     *
     * If the user is not authenticated we load the empty layout.
     *
     * @param  MvcEvent $event
     * @return void
     */
    public function setLayout(MvcEvent $event)
    {
        // Get AuthenticationService and do the verification.
        $services    = $event->getApplication()->getServiceManager();
        $authService = $services->get('SimpleInvoices\AuthenticationService');
        
        if ($authService->hasIdentity()) {
            return;
        }
        
        // We are not authenticated, therefore load the empty layout
        $controller = $event->getTarget();
        if (!is_object($controller)) {
            return;
        }
        
        if ($controller instanceof AbstractController) {
            $controller->layout('layout/empty');
            return;
        }
        
        $viewModel = $event->getViewModel();
        $viewModel->setTemplate('layout/empty');
    }
    
    /**
     * Retrieve the event manager
     *
     * Lazy-loads an EventManager instance if none registered.
     *
     * @return EventManagerInterface
     */
    public function getEventManager()
    {
        return $this->events;
    }

    /**
     * Listener to the "bootstrap" event and start the session.
     * 
     * @param MvcEvent $event
     * @return void
     */
    public function initSession(MvcEvent $event)
    {
        $session = $event->getApplication()->getServiceManager()->get(SessionManager::class);
        
        $sessionContainer = new SessionContainer('si_auth');
        SessionContainer::setDefaultManager($session);
        
        // Initialize a guest session if necessary
        if (!isset($sessionContainer->id)) {
            $sessionContainer->id        = 0;
            $sessionContainer->email     = 'demo@simpleinvoices.org';
            $sessionContainer->enabled   = 1;
            $sessionContainer->role_id   = 0;
            $sessionContainer->role      = 'guest';
        }
        
        $session->start();
    }

    /**
     * Inject an EventManager instance
     *
     * @param  EventManagerInterface $eventManager
     * @return void
     */
    public function setEventManager(EventManagerInterface $eventManager)
    {
        $this->events = $eventManager;
    }
}
