<?php

namespace Cyclos;

/**
 * Class Api
 *
 * Essentially, this is the class containing factory methods
 * for all Cyclos API collections currently supported by this library.
 *
 * @package Cyclos
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

    /**
     * @return \Cyclos\Apis\AccountsApi
     */
    public static function getAccounts()
    {
        return new Apis\AccountsApi;
    }

    public static function getPayments()
    {
        
    }


    public static function getUsers()
    {

    }
}