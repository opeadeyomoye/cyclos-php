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
     * @return \Cyclos\Apis\AuthApi
     */
    public static function getAuth()
    {
        return new Apis\AuthApi();
    }


    public static function getPayments()
    {
        
    }


    public static function getUsers()
    {

    }
}