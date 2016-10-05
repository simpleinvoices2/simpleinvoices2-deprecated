<?php
/**
 * @link      http://github.com/simpleinvoices2/simpleinvoices2
 * @copyright Copyright (c) 2016 Juan Pedro Gonzalez Gutierrez
 * @license   http://github.com/simpleinvoices2/simpleinvoices2/LICENSE GPL v3.0
 */
namespace SimpleInvoices\PaymentMethod\Form;

use Zend\Form\Form;

class PaymentMethodForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('tax-rate');

        $this->setAttribute('class', 'payment-method-form');
        $this->setAttribute('id', 'payment-method-form');

        $this->add([
            'name' => 'description',
            'type' => 'Text',
            'options' => [
                'label' => 'Description',
            ],
            'attributes' => [
                'class'       => 'form-control',
                'required'    => 'required',
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
                'id'    => 'save-payment-method',
                'class' => 'btn btn-lg btn-success',
            ],
        ]);
    }
}