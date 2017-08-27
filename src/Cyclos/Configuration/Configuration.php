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
 *
 * @package Cyclos\Configuration
 *
 * @todo Allow devs set preferred http client in zis config class?
 */
class Configuration
{
    // default configuration
    protected $rootUrl   = 'https://demo.cyclos.org';
    protected $username  = 'demo';
    protected $password  = '1234';
    protected $sessionToken = '';
    protected $accessClient = '';

    private static $_globalConfig;

    /**
     * Class constructor.
     * 
     * Loads all the parameters in $config into the new instance.
     *
     * @param array $config
     */
    private function __construct($config = [])
    {
        // @todo: try to set these guys publicly to remove the need for getters?
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

        unset($defaultConfig['_globalConfig']);

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
     *
     * @throws \Exception If we can't find Vance's phpdotenv library.
     * @throws \RuntimeException If any of the required environment variables were not found.
     */
    public static function loadFromEnvironment($path, $file = '.env')
    {
        if (!class_exists('\Dotenv\Dotenv')) {
            throw new \Exception(
                'The "vlucas/phpdotenv" composer package is required to load environment variables 
                in ' . __FILE__
            );
        }
        $dotenv = new \Dotenv\Dotenv($path, $file);
        $dotenv->required(static::environmentVariableNames());
        $dotenv->load();
        return (new self([]))->loadEnv();
    }


    /**
     * Sets a global(ish) configuration object.
     *
     * @param Configuration $config
     * @return void
     */
    private static function setGlobalConfig(Configuration $config)
    {
        static::$_globalConfig = $config;
    }


    /**
     * Get a clone of the global(ish) configuration object.
     * 
     * Returns a new instance of the configuration class containing the (hardcoded)
     * defaults if no global config object has been set.
     *
     * @return Configuration
     */
    public static function getGlobalConfig()
    {
        return (static::$_globalConfig) ? clone(static::$_globalConfig) : self::get();
    }

    /**
     * Make (a clone of) $this the global configuration object.
     *
     * @return Configuration
     */
    public function globalize()
    {
        static::setGlobalConfig(clone($this));
        return $this;
    }

    public function makeItGlobal()
    {
        return $this->globalize();
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
     * @throws \Exception If any of the required environment variables are missing.
     */
    public function loadEnv()
    {
        $variableNames = static::environmentVariableNames();
        $environmentVariables = array_intersect_key($_ENV, array_flip($variableNames));

        if (!(array_keys($environmentVariables) === array_values($variableNames))) {
            throw new \Exception(
                'Some environment variables required for Cyclos configuration are missing.'
            );
        }

        list($rootUrl, $username, $password) = array_values($environmentVariables);
        return $this->setRootUrl($rootUrl)
                    ->setUsername($username)
                    ->setPassword($password);
    }

    // setters and getters...
    public function setRootUrl($rootUrl)
    {
        $this->rootUrl = $rootUrl;
        return $this;
    }

    public function getRootUrl()
    {
        return $this->rootUrl;
    }

    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setSessionToken($sessionToken)
    {
        $this->sessionToken = $sessionToken;
        return $this;
    }

    public function getSessionToken()
    {
        return $this->sessionToken;
    }

    public function setAccessClient($accessClient)
    {
        $this->accessClient = $accessClient;
        return $this;
    }

    public function getAccessClient()
    {
        return $this->accessClient;
    }
}
