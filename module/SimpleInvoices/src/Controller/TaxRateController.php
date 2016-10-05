<?php
/**
 * @link      http://github.com/simpleinvoices2/simpleinvoices2
 * @copyright Copyright (c) 2016 Juan Pedro Gonzalez Gutierrez
 * @license   http://github.com/simpleinvoices2/simpleinvoices2/LICENSE GPL v3.0
 */

namespace SimpleInvoices\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use SimpleInvoices\TaxRate\TaxRateManagerInterface;
use SimpleInvoices\TaxRate\Form\TaxRateForm;
use SimpleInvoices\Core\Form\DeleteByIdForm;

class TaxRateController extends AbstractActionController
{
    /**
     * @var TaxRateManagerInterface
     */
    protected $taxRateManager;
    
    public function __construct(TaxRateManagerInterface $taxRateManager)
    {
        $this->taxRateManager = $taxRateManager;
    }
    
    public function indexAction()
    {
        $paginator = $this->taxRateManager->getAllTaxes(true);
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
       
        $form = new TaxRateForm();
        
        if ($this->request->isPost()) {
            $id  = (int) $this->request->getPost('id', 0);
            $tax = $this->taxRateManager->getTax($id);
            
            $form->setData($this->request->getPost());
            if ($form->isValid()) {
                // Save the post
                $tax->setDescription($this->request->getPost('description'));
                $tax->setPercentage($this->request->getPost('percentage'));
                $tax->setType($this->request->getPost('type'));
                $tax->setEnabled($this->request->getPost('enabled'));
                
                if ($this->taxRateManager->save($tax)) {
                    return $this->redirect()->toRoute('taxrates');
                } else {
                    $error = true;
                }
            } else {
                $error = true;
            }
        } else {
            $id  = (int) $this->params()->fromQuery('id', 1);
            $tax = $this->taxRateManager->getTax($id);
        }
       
        $form->setData($tax->toArray());
        
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
                
                if ($this->taxRateManager->delete($id)) {
                    return $this->redirect()->toRoute('taxrates');
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
        
        $form = new TaxRateForm();
        
        if ($this->request->isPost()) {
            $form->setData($this->request->getPost());
            if ($form->isValid()) {
                // Save the post
                $tax = $this->taxRateManager->getTaxRatePrototype();
            
                $tax->setDescription($this->request->getPost('description'));
                $tax->setPercentage($this->request->getPost('percentage'));
                $tax->setType($this->request->getPost('type'));
                $tax->setEnabled($this->request->getPost('enabled'));
            
                if ($this->taxRateManager->save($tax)) {
                    return $this->redirect()->toRoute('taxrates');
                } else {
                    $error = true;
                }
            } else {
                $error = true;
            }
        } else {
            // Feeds default values to Taxes
            $tax = $this->taxRateManager->getTaxRatePrototype();
            $form->setData($tax->toArray());
        }
        
        return new ViewModel([
            'form'  => $form,
            'error' => $error,
        ]);
    }
}
