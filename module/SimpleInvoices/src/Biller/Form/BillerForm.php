<?php
/**
 * @link      http://github.com/simpleinvoices2/simpleinvoices2
 * @copyright Copyright (c) 2016 Juan Pedro Gonzalez Gutierrez
 * @license   http://github.com/simpleinvoices2/simpleinvoices2/LICENSE GPL v3.0
 */

namespace SimpleInvoices\Biller\Form;

use Zend\Form\Form;

class BillerForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('biller');
    
        $this->setAttribute('class', 'biller-form');
        $this->setAttribute('id', 'biller-form');
    
        $this->add([
            'name' => 'name',
            'type' => 'Text',
            'options' => [
                'label' => 'Name',
            ],
            'attributes' => [
                'class'       => 'form-control',
                'required'    => 'required',
            ]
        ]);
    
        $this->add([
            'name' => 'street_address',
            'type' => 'Text',
            'options' => [
                'label' => 'Street Addess',
            ],
            'attributes' => [
                'class'    => 'form-control',
                'required' => 'required',
            ]
        ]);
        
        $this->add([
            'name' => 'street_address2',
            'type' => 'Text',
            'options' => [
                'label' => 'Street Addess 2',
            ],
            'attributes' => [
                'class'    => 'form-control',
            ]
        ]);
        
        $this->add([
            'name' => 'city',
            'type' => 'Text',
            'options' => [
                'label' => 'City',
            ],
            'attributes' => [
                'class'    => 'form-control',
            ]
        ]);
        
        $this->add([
            'name' => 'state',
            'type' => 'Text',
            'options' => [
                'label' => 'State',
            ],
            'attributes' => [
                'class'    => 'form-control',
            ]
        ]);
        
        $this->add([
            'name' => 'zip_code',
            'type' => 'Text',
            'options' => [
                'label' => 'ZIP Code',
            ],
            'attributes' => [
                'class'    => 'form-control',
            ]
        ]);
        
        $this->add([
            'name' => 'country',
            'type' => 'Text',
            'options' => [
                'label' => 'Country',
            ],
            'attributes' => [
                'class'    => 'form-control',
            ]
        ]);
        
        $this->add([
            'name' => 'phone',
            'type' => 'Text',
            'options' => [
                'label' => 'Phone Number',
            ],
            'attributes' => [
                'class'    => 'form-control',
            ]
        ]);
        
        $this->add([
            'name' => 'mobile_phone',
            'type' => 'Text',
            'options' => [
                'label' => 'Mobile Phone Number',
            ],
            'attributes' => [
                'class'    => 'form-control',
            ]
        ]);
        
        $this->add([
            'name' => 'fax',
            'type' => 'Text',
            'options' => [
                'label' => 'FAX Number',
            ],
            'attributes' => [
                'class'    => 'form-control',
            ]
        ]);
        
        $this->add([
            'name' => 'email',
            'type' => 'Text',
            'options' => [
                'label' => 'Email Address',
            ],
            'attributes' => [
                'class'    => 'form-control',
            ]
        ]);
        
        // TODO: TextArea
        $this->add([
            'name' => 'comments',
            'type' => 'Textarea',
            'options' => [
                'label' => 'Comments',
            ],
            'attributes' => [
                'class'    => 'form-control',
            ]
        ]);
        
        
    
        
    
        $this->add([
            'name' => 'enabled',
            'type' => 'Checkbox',
            'options' => [
                'label' => 'Enabled',
            ],
        ]);
    
        $this->add([
            'type' => 'Hidden',
            'name' => 'id',
        ]);
    
        $this->add([
            'type' => 'Zend\Form\Element\Csrf',
            'name' => 'csrf',
            'options' => [
                'csrf_options' => [
                    'timeout' => 600
                ],
            ],
        ]);
    
        $this->add([
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => [
                'value' => 'Save',
                'id'    => 'save-tax-rate',
                'class' => 'btn btn-lg btn-success',
            ],
        ]);
    }
}