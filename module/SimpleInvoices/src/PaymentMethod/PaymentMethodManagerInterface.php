<?php
/**
 * @link      http://github.com/simpleinvoices2/simpleinvoices2
 * @copyright Copyright (c) 2016 Juan Pedro Gonzalez Gutierrez
 * @license   http://github.com/simpleinvoices2/simpleinvoices2/LICENSE GPL v3.0
 */

namespace SimpleInvoices\PaymentMethod;

Interface PaymentMethodManagerInterface
{
    /**
     * Delete a payment method.
     *
     * @param PaymentMethodInterface|int $paymentMethod Can either be the payment method ID or a PaymentMethodInterface object.
     */
    public function delete($paymentMethod);
    
    /**
     * Get all payment method.
     *
     * @param bool $paginated
     * @return \Zend\Paginator\Paginator|\Zend\Db\ResultSet\ResultSet
     */
    public function getAllPaymentMethods($paginated = false);
    
    /**
     * Get the given payment method.
     *
     * @param int $id The payment method ID.
     */
    public function getPaymentMethod($id);
    
    /**
     * Get the payment method prototype class.
     *
     * @return PaymentMethodInterface
     */
    public function getPaymentMethodPrototype();
    
    /**
     * Save a payment method.
     *
     * @param PaymentMethodInterface $tax
     */
    public function save(PaymentMethodInterface $paymentMethod);
    
}