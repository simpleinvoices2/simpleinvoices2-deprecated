<?php
/**
 * @link      http://github.com/simpleinvoices2/simpleinvoices2
 * @copyright Copyright (c) 2016 Juan Pedro Gonzalez Gutierrez
 * @license   http://github.com/simpleinvoices2/simpleinvoices2/LICENSE GPL v3.0
 */

namespace SimpleInvoices\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use SimpleInvoices\Customer\CustomerManagerInterface;
use SimpleInvoices\Core\Form\DeleteByIdForm;
use SimpleInvoices\Customer\Form\CustomerForm;
use SimpleInvoices\Customer\CustomerInterface;

class CustomersController extends AbstractActionController
{
    /**
     * @var CustomerManagerInterface
     */
    protected $customerManager;
    
    public function __construct(CustomerManagerInterface $customerManager)
    {
        $this->customerManager = $customerManager;
    }
    
    public function indexAction()
    {
        $paginator = $this->customerManager->getAllCustomers(true);
        $paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));
        // set the number of items per page to 10
        $paginator->setItemCountPerPage(10);
        
        return new ViewModel([
            'paginator' => $paginator
        ]);
    }
    
    public function newAction()
    {
        $error = false;
        
        $form = new CustomerForm();
        
        if ($this->request->isPost()) {
            $form->setData($this->request->getPost());
            if ($form->isValid()) {
                // Save the post
                $customer = $this->customerManager->getObjectPrototype();
            
                $customer->setName($this->request->getPost('name'));
                $customer->setStreetAddress($this->request->getPost('street_address'));
                $customer->setStreetAddress2($this->request->getPost('street_address2'));
                $customer->setCity($this->request->getPost('city'));
                $customer->setState($this->request->getPost('state'));
                $customer->setZipCode($this->request->getPost('zip_code'));
                $customer->setCountry($this->request->getPost('country'));
                $customer->setPhone($this->request->getPost('phone'));
                $customer->setMobilePhone($this->request->getPost('mobile_phone'));
                $customer->setFax($this->request->getPost('fax'));
                $customer->setEmailAddress($this->request->getPost('email'));
                $customer->setComments($this->request->getPost('comments'));
                $customer->setEnabled($this->request->getPost('enabled'));
            
                if ($this->customerManager->save($customer)) {
                    return $this->redirect()->toRoute('customers');
                } else {
                    $error = true;
                }
            } else {
                $error = true;
            }
        } else {
            // Feeds default values to Taxes
            $customer = $this->customerManager->getObjectPrototype();
            $form->setData($customer->toArray());
        }
        
        return new ViewModel([
            'form'  => $form,
            'error' => $error,
        ]);
    }
    
    public function editAction()
    {
        $error = false;
       
        $form = new CustomerForm();
        
        if ($this->request->isPost()) {
            $id  = (int) $this->request->getPost('id', 0);
            $customer = $this->customerManager->getCustomer($id);
            
            $form->setData($this->request->getPost());
            if ($form->isValid()) {
                // Save the post
                $customer->setName($this->request->getPost('name'));
                $customer->setStreetAddress($this->request->getPost('street_address'));
                $customer->setStreetAddress2($this->request->getPost('street_address2'));
                $customer->setCity($this->request->getPost('city'));
                $customer->setState($this->request->getPost('state'));
                $customer->setZipCode($this->request->getPost('zip_code'));
                $customer->setCountry($this->request->getPost('country'));
                $customer->setPhone($this->request->getPost('phone'));
                $customer->setMobilePhone($this->request->getPost('mobile_phone'));
                $customer->setFax($this->request->getPost('fax'));
                $customer->setEmailAddress($this->request->getPost('email'));
                $customer->setComments($this->request->getPost('comments'));
                $customer->setEnabled($this->request->getPost('enabled'));
                
                if ($this->customerManager->save($customer)) {
                    return $this->redirect()->toRoute('customers');
                } else {
                    $error = true;
                }
            } else {
                $error = true;
            }
        } else {
            $id       = (int) $this->params()->fromQuery('id', 1);
            $customer = $this->customerManager->getCustomer($id);
        }
       
        $form->setData($customer->toArray());
        
        return new ViewModel([
            'form' => $form,
            'error' => $error,
        ]);
    }
    
    public function deleteAction()
    {
        $error = false;
        
        $form = new DeleteByIdForm('delete-customer-form');
        
        if ($this->request->isPost()) {
            $form->setData($this->request->getPost());
            if ($form->isValid()) {
                $id  = (int) $this->request->getPost('id');
        
                if ($this->customerManager->delete($id)) {
                    return $this->redirect()->toRoute('customers');
                } else {
                    $error = true;
                }
            } else {
                $error = true;
            }
        } else {
            $id  = (int) $this->params()->fromQuery('id', 1);
            $form->setData(['id' => $id]);
        }
        
        return new ViewModel([
            'error' => $error,
            'form'  => $form,
        ]);
    }
}