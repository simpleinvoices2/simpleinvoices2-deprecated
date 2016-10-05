<?php
/**
 * @link      http://github.com/simpleinvoices2/simpleinvoices2
 * @copyright Copyright (c) 2016 Juan Pedro Gonzalez Gutierrez
 * @license   http://github.com/simpleinvoices2/simpleinvoices2/LICENSE GPL v3.0
 */

namespace SimpleInvoices\Core\Form;

use Zend\Form\Form;
use Zend\Form\Element;

/**
 * A simple form to delete any record by ID while ensuring CSRF.
 * 
 * @author Juan Pedro Gonzalez Gutierrez
 */
class DeleteByIdForm extends Form
{
    /**
     * Constructor.
     * 
     * @param  null|int|string  $name    Optional name for the element
     * @param  array            $options Optional options for the element
     */
    public function __construct($name = null, $options = [])
    {
        parent::__construct($name, $options);
        
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
                'value' => 'Delete',
                'class' => 'btn btn-lg btn-success',
            ],
        ]);
    }
}