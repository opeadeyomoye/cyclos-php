<?php

namespace Cyclos\Configuration;

/**
 * Configuration class
 * 
 * Holds and loads (no pun intended) basic info used to access a specific Cyclos instance.
 * The default configuration here allows you to whip up requests to Cyclos' demo platform.
 * 
 * @property string $rootUrl
 * @property string $username
 * @property string $password
 * @property string $sessionToken
 * @property string $accessClient
 */
class Configuration
{
    /*
     | In a bid to avoid "global state" for config, here's what we'll try:
     | 
     | Have protected, static properties that will hold config.
     | The protected config can ONLY be modified via a static interface, and the only
     | real "modification" that can be done is reload the config from the dotenv file,
     | or reload the default (manually-set) config from wherever that resides.
     |
     | Have static methods to reload the manual or dotenv config into a new config object.
     | This way, we've got global defaults, but dependents use seperate instances, hence we avoid
     | creating a "recipe for disaster" or all that other bad news associated with global variables.
     | 
     | Oh, and we'll probably use an interface for creating config classes. Hmm, we could even
     | make the constructor private, then we'll provide a static interface for creating new instances
     | while avoiding the apparently evil singleton instance.
    */

    /*
     | One can instantiate and populate config objects
     | One can setConfig() on Api objects
     | Api objects set initial config on instantiation
     | 
    */

    // default configuration
    protected static $rootUrl   = 'https://demo.cyclos.org';
    protected static $username  = 'demo';
    protected static $password  = '1234';
    protected static $sessionToken = '';
    protected static $accessClient = '';

    /**
     * Class constructor.
     * 
     * Loads all the parameters in $config into the new instance.
     *
     * @param array $config
     */
    private function __construct($config = [])
    {
        foreach ($config as $property => $value) {
            $this->{$property} = $value;
        }
    }


    /**
     * Get an instance of this class, loading the default configuration.
     *
     * @return Configuration
     */
    public static function get()
    {
        $defaultConfig = get_class_vars(static::class);
        return new self($defaultConfig);
    }


    /**
     * Get an instance of this class, loading configuration from a .env file.
     *
     * @param string $path 
     * @param string $file
     * 
     * @return Configuration
     * 
     * @see Configuration::environmentVariableNames() For required environment variables.
     * @throws \RuntimeException If any of the required environment variables were not found.
     */
    public static function loadFromEnvironment($path, $file = '.env')
    {
        if (!class_exists('\Dotenv\Dotenv')) {
            // throw
        }
        $dotenv = new \Dotenv\Dotenv($path, $file);
        $dotenv->required(static::environmentVariableNames());
        $dotenv->load();
        return (new self([]))->loadEnv();
    }

    /**
     * Returns an array of default (, required) environment variable names.
     *
     * @return array
     */
    public static function environmentVariableNames()
    {
        return [
            'CYCLOS_ROOT_URL',
            'CYCLOS_LOGIN_USERNAME',
            'CYCLOS_LOGIN_PASSWORD'
        ];
    }


    /**
     * Loads required environment variable names into the current Configuration object.
     * 
     * This is particularly useful if you already have the required environment variables
     * set (one way or another) and you don't need (or want) to use
     * {@link https://github.com/vlucas/phpdotenv phpdotenv} to load them.
     *
     * @return Configuration
     * 
     * @throws \RuntimeException If any of of the required environment variables are missing.
     */
    public function loadEnv()
    {
        $variableNames = static::environmentVariableNames();
        $environmentVariables = array_intersect_key($_ENV, array_flip($variableNames));

        if (!(array_keys($environmentVariables) === array_values($variableNames))) {
            // throw. Preferably same thing Dotenv throws
        }
        list($rootUrl, $username, $password) = array_values($environmentVariables);
        return $this->setRootUrl($rootUrl)
                    ->setUsername($username)
                    ->setPassword($password);
    }

    // setters...
    public function setRootUrl($rootUrl)
    {
        $this->rootUrl = $rootUrl;
        return $this;
    }

    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    public function setSessionToken($sessionToken)
    {
        $this->sessionToken = $sessionToken;
        return $this;
    }

    public function setAccessClient($accessClient)
    {
        $this->accessClient = $accessClient;
        return $this;
    }
}
