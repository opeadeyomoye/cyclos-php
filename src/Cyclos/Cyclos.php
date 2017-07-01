<?php

namespace Cyclos;

use \ArrayObject;

class Cyclos
{
    public function getJar(ArrayObject $object)
    {
        $data = [
            'principal' => 'james',
            'amount' => 'type',
            'type' => 'account.PaymentType'
        ];
        $paymentApi = Cyclos\Api::getPayment();
        $payment = Cyclos\Model::getDataForPayment();

        $payment->set($data);

        $paymentApi->performPayment('self', $payment)
            ->withHeader('this')
            ->expect(new Model())
            ->send();
        
        return true;
    }
}
/**
 * Models ==> objects representing request datasets
         ==> objects representing response types, formats, datasets
 * 
 * Requests => endpoint url sections, request method, 
 * Client and configuration
 */
