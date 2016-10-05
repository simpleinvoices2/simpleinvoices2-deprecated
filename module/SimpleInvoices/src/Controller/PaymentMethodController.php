<?php
/**
 * @link      http://github.com/simpleinvoices2/simpleinvoices2
 * @copyright Copyright (c) 2016 Juan Pedro Gonzalez Gutierrez
 * @license   http://github.com/simpleinvoices2/simpleinvoices2/LICENSE GPL v3.0
 */

namespace SimpleInvoices\Controller;

use SimpleInvoices\PaymentMethod\PaymentMethodManagerInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use SimpleInvoices\PaymentMethod\Form\PaymentMethodForm;
use SimpleInvoices\Core\Form\DeleteByIdForm;

class PaymentMethodController extends AbstractActionController
{
    /**
     * @var PaymentMethodManagerInterface
     */
    protected $paymentMethodManager;
    
    public function __construct(PaymentMethodManagerInterface $paymentMethodManager)
    {
        $this->paymentMethodManager = $paymentMethodManager;
    }
    
    public function indexAction()
    {
        $paginator = $this->paymentMethodManager->getAllPaymentMethods(true);
        $paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));
        // set the number of items per page to 10
        $paginator->setItemCountPerPage(10);
        
        return new ViewModel([
            'paginator' => $paginator
        ]);
    }
    
    public function editAction()
    {
        $error = false;
       
        $form = new PaymentMethodForm();
        
        if ($this->request->isPost()) {
            $id            = (int) $this->request->getPost('id', 0);
            $paymentMethod = $this->paymentMethodManager->getPaymentMethod($id);
            
            $form->setData($this->request->getPost());
            if ($form->isValid()) {
                // Save the post
                $paymentMethod->setDescription($this->request->getPost('description'));
                $paymentMethod->setEnabled($this->request->getPost('enabled'));
                
                if ($this->paymentMethodManager->save($paymentMethod)) {
                    return $this->redirect()->toRoute('paymentmethods');
                } else {
                    $error = true;
                }
            } else {
                $error = true;
            }
        } else {
            $id            = (int) $this->params()->fromQuery('id', 1);
            $paymentMethod = $this->paymentMethodManager->getPaymentMethod($id);
        }
       
        $form->setData($paymentMethod->toArray());
        
        return new ViewModel([
            'form' => $form,
            'error' => $error,
        ]);
    }
    
    public function deleteAction()
    {
        $error = false;
        
        $form = new DeleteByIdForm();
        
        if ($this->request->isPost()) {
            $form->setData($this->request->getPost());
            if ($form->isValid()) {
                $id  = (int) $this->request->getPost('id');
                
                if ($this->paymentMethodManager->delete($id)) {
                    return $this->redirect()->toRoute('paymentmethods');
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
    
    public function newAction()
    {
        $error = false;
        
        $form = new PaymentMethodForm();
        
        if ($this->request->isPost()) {
            $form->setData($this->request->getPost());
            if ($form->isValid()) {
                // Save the post
                $paymentMethod = $this->paymentMethodManager->getPaymentMethodPrototype();
            
                $paymentMethod->setDescription($this->request->getPost('description'));
                $paymentMethod->setEnabled($this->request->getPost('enabled'));
            
                if ($this->paymentMethodManager->save($paymentMethod)) {
                    return $this->redirect()->toRoute('paymentmethods');
                } else {
                    $error = true;
                }
            } else {
                $error = true;
            }
        } else {
            // Feeds default values to Payment Method
            $paymentMethod = $this->paymentMethodManager->getPaymentMethodPrototype();
            $form->setData($paymentMethod->toArray());
        }
        
        return new ViewModel([
            'form'  => $form,
            'error' => $error,
        ]);
    }
}
