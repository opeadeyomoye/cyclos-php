<?php

namespace Cyclos;

/**
 * Essentially, this is the class containing factory methods
 * for all Cyclos API endpoints currently supported by this library.
 * 
 * For now.
 */
class Api
{
    /**
     * @return Apis\AuthApi
     */
    public function getAuth()
    {
        return new Apis\AuthApi();
    }


    public function getPayments()
    {
        
    }


    public function getUsers()
    {

    }
}