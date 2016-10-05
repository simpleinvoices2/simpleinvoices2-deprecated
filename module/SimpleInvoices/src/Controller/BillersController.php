<?php
/**
 * @link      http://github.com/simpleinvoices2/simpleinvoices2
 * @copyright Copyright (c) 2016 Juan Pedro Gonzalez Gutierrez
 * @license   http://github.com/simpleinvoices2/simpleinvoices2/LICENSE GPL v3.0
 */

namespace SimpleInvoices\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use SimpleInvoices\Core\Form\DeleteByIdForm;
use SimpleInvoices\Biller\BillerManagerInterface;
use SimpleInvoices\Biller\Form\BillerForm;


class BillersController extends AbstractActionController
{
    /**
     * @var BillerManagerInterface
     */
    protected $billerManager;
    
    public function __construct(BillerManagerInterface $billerManager)
    {
        $this->billerManager = $billerManager;
    }
    
    public function indexAction()
    {
        $paginator = $this->billerManager->getAllBillers(true);
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
        
        $form = new BillerForm();
        
        if ($this->request->isPost()) {
            $form->setData($this->request->getPost());
            if ($form->isValid()) {
                // Save the post
                $biller = $this->billerManager->getObjectPrototype();
            
                $biller->setName($this->request->getPost('name'));
                $biller->setStreetAddress($this->request->getPost('street_address'));
                $biller->setStreetAddress2($this->request->getPost('street_address2'));
                $biller->setCity($this->request->getPost('city'));
                $biller->setState($this->request->getPost('state'));
                $biller->setZipCode($this->request->getPost('zip_code'));
                $biller->setCountry($this->request->getPost('country'));
                $biller->setPhone($this->request->getPost('phone'));
                $biller->setMobilePhone($this->request->getPost('mobile_phone'));
                $biller->setFax($this->request->getPost('fax'));
                $biller->setEmailAddress($this->request->getPost('email'));
                $biller->setComments($this->request->getPost('comments'));
                $biller->setEnabled($this->request->getPost('enabled'));
            
                if ($this->billerManager->save($biller)) {
                    return $this->redirect()->toRoute('billers');
                } else {
                    $error = true;
                }
            } else {
                $error = true;
            }
        } else {
            // Feeds default values to Taxes
            $biller = $this->billerManager->getObjectPrototype();
            $form->setData($biller->toArray());
        }
        
        return new ViewModel([
            'form'  => $form,
            'error' => $error,
        ]);
    }
    
    public function editAction()
    {
        $error = false;
       
        $form = new BillerForm();
        
        if ($this->request->isPost()) {
            $id  = (int) $this->request->getPost('id', 0);
            $biller = $this->billerManager->getBiller($id);
            
            $form->setData($this->request->getPost());
            if ($form->isValid()) {
                // Save the post
                $biller->setName($this->request->getPost('name'));
                $biller->setStreetAddress($this->request->getPost('street_address'));
                $biller->setStreetAddress2($this->request->getPost('street_address2'));
                $biller->setCity($this->request->getPost('city'));
                $biller->setState($this->request->getPost('state'));
                $biller->setZipCode($this->request->getPost('zip_code'));
                $biller->setCountry($this->request->getPost('country'));
                $biller->setPhone($this->request->getPost('phone'));
                $biller->setMobilePhone($this->request->getPost('mobile_phone'));
                $biller->setFax($this->request->getPost('fax'));
                $biller->setEmailAddress($this->request->getPost('email'));
                $biller->setComments($this->request->getPost('comments'));
                $biller->setEnabled($this->request->getPost('enabled'));
                
                if ($this->billerManager->save($biller)) {
                    return $this->redirect()->toRoute('billers');
                } else {
                    $error = true;
                }
            } else {
                $error = true;
            }
        } else {
            $id       = (int) $this->params()->fromQuery('id', 1);
            $biller = $this->billerManager->getBiller($id);
        }
       
        $form->setData($biller->toArray());
        
        return new ViewModel([
            'form' => $form,
            'error' => $error,
        ]);
    }
    
    public function deleteAction()
    {
        $error = false;
        
        $form = new DeleteByIdForm('delete-biller-form');
        
        if ($this->request->isPost()) {
            $form->setData($this->request->getPost());
            if ($form->isValid()) {
                $id  = (int) $this->request->getPost('id');
        
                if ($this->billerManager->delete($id)) {
                    return $this->redirect()->toRoute('billers');
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