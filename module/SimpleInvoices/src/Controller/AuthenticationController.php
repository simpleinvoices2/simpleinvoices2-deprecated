<?php
/**
 * @link      http://github.com/simpleinvoices2/simpleinvoices2
 * @copyright Copyright (c) 2016 Juan Pedro Gonzalez Gutierrez
 * @license   http://github.com/simpleinvoices2/simpleinvoices2/LICENSE GPL v3.0
 */

namespace SimpleInvoices\Controller;

use SimpleInvoices\Authentication\Form\LoginForm;
use Zend\Authentication\AuthenticationServiceInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container as SessionContainer;
use Zend\View\Model\ViewModel;
use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\Driver\ResultInterface;

class AuthenticationController extends AbstractActionController
{
	/**
	 * @var AuthenticationServiceInterface
	 */
	protected $authenticationService;
	
	/**
	 * @var Adapter
	 */
	protected $adapter;

    public function __construct(AuthenticationServiceInterface $authenticationService, AdapterInterface $adapter)
    {
        $this->authenticationService = $authenticationService;
        $this->adapter = $adapter;
    }

    public function indexAction()
    {

        return new ViewModel();
    }

    public function loginAction()
    {
    	//if already login, redirect to success page 
        if ($this->authenticationService->hasIdentity()) {
            return $this->redirect()->toRoute('home');
        }
        
        $form = new LoginForm();
        
        if ($this->request->isPost()) {
            $form->setData($this->request->getPost());
            if ($form->isValid()) {
                $this->authenticationService->getAdapter()
                     ->setIdentity($this->request->getPost('username'))
                     ->setCredential($this->request->getPost('password'));
                $result = $this->authenticationService->authenticate();
                if ($result->isValid()) {
                    $sessionContainer = new SessionContainer('si_auth');
                    $userArray = $this->authenticationService->getAdapter()->getResultRowObject(null, ['password']);
                    foreach ($userArray as $key => $value) {
                        if ($key === 'role_id') {
                            // Get the domain...
                            $sql = new Sql($this->adapter, 'si_user_role');
                            $select = $sql->select();
                            $select->where(['id' => $value]);
                            $statement = $sql->prepareStatementForSqlObject($select);
                            $result = $statement->execute();
                            if ($result instanceof ResultInterface && $result->isQueryResult()) {
                                $current = $result->current();
                                if (isset($current['name'])) {
                                    $sessionContainer->role = $current['name'];
                                } else {
                                    $sessionContainer->role = $value;
                                }
                            } else {
                                $sessionContainer->role = $value;
                            }
                        } elseif ($key === 'domain_id') {
                            // Get the domain...
                            $sql = new Sql($this->adapter, 'si_user_domain');
                            $select = $sql->select();
                            $select->where(['id' => $value]);
                            $statement = $sql->prepareStatementForSqlObject($select);
                            $result = $statement->execute();
                            if ($result instanceof ResultInterface && $result->isQueryResult()) {
                                $current = $result->current();
                                if (isset($current['name'])) {
                                    $sessionContainer->domain = $current['name'];
                                } else {
                                    $sessionContainer->domain = $value;
                                }
                            } else {
                                $sessionContainer->domain = $value;
                            }
                        }
                        
                        $sessionContainer->$key = $value;
                    }
                    
                    return $this->redirect()->toRoute('home');
                }
            }
        }
         
        return [
            'form'      => $form,
        ];
    }

    public function logoutAction()
    {
    	//$this->getSessionStorage()->forgetMe();
        $this->authenticationService->clearIdentity();
         
        return $this->redirect()->toRoute('login');
    }
}
