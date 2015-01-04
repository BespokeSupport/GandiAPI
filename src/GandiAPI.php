<?php
/**
 * This file is part of the GandiAPI PHP Class.
 *
 * PHP Version 5
 *
 * @category API
 * @author   Richard Seymour <web@bespoke.support>
 * @license  http://creativecommons.org/licenses/by/3.0/deed.en_GB CC-By
 * @link     https://github.com/RickSeymour/GandiAPI
 */

namespace BespokeSupport\Gandi;

/**
 * Class GandiAPI
 * @package BespokeSupport\Gandi
 */
class GandiAPI
{
    /**
     *  EndPoint for Live API
     */
    const URL_LIVE = 'https://rpc.gandi.net/xmlrpc/';
    /**
     *  EndPoint for OTE Test API
     */
    const URL_TEST = 'https://rpc.ote.gandi.net/xmlrpc/';

    /**
     * @var bool Live/Test
     */
    public $live = false;

    /**
     * @var string API Key being used
     */
    protected $apiKey;

    /**
     * @var string method being used
     */
    protected $prefix = '';

    /**
     * Instantiates class
     *
     * @param string|null $apiKey API Key (https://www.gandi.net/admin/api_key)
     * @param bool        $live   from parent class
     *
     * @throws GandiException
     */
    public function __construct($apiKey = null, $live = false)
    {
        if (!$apiKey) {
            throw new GandiException(GandiException::ERROR_API_KEY_REQUIRED);
        } elseif (!preg_match('/^[a-zA-Z0-9]{24}$/', $apiKey)) {
            throw new GandiException(GandiException::ERROR_API_KEY_INVALID);
        }

        $this->apiKey = $apiKey;

        if ($live === false) {
            $this->live = false;
        } else {
            $this->live = true;
        }
    }

    /**
     * Allows for chaining of api prefix
     *
     * @param string $property API Section
     * @return $this
     */
    function __get($property)
    {
        $property = preg_replace_callback(
            '#([\p{Lu}]+)#',
            function ($matches) {
                return strtolower('.' . $matches[0]);
            },
            $property
        );

        if (!empty($property)) {
            $this->prefix = $property;
        }

        return $this;
    }

    /**
     * Calls XML_RPC Class
     *
     * @param string $method final endpoint of call
     * @param mixed  $args   variable length array
     *
     * @return mixed
     */
    function __call($method, $args)
    {
        $method = preg_replace_callback(
            '#([\p{Lu}]+)#',
            function ($matches) {
                return strtolower('.' . $matches[0]);
            },
            $method
        );

        /**
         * @var $xml \XML_RPC2_Backend_Php_Client
         */
        $xml = \XML_RPC2_Client::create(
            $this->getUrl(),
            array(
                'sslverify' => false,
                'prefix' => $this->getPrefix() . '.'
            )
        );

        if (isset($args[1])) {
            return $xml->__call(
                $method,
                array(
                    $this->getApiKey(),
                    $args[0],
                    $args[1]
                )
            );
        } elseif (isset($args[0])) {
            return $xml->__call(
                $method,
                array(
                    $this->getApiKey(),
                    $args[0]
                )
            );
        } else {
            return $xml->__call(
                $method,
                array(
                    $this->getApiKey()
                )
            );
        }
    }

    /**
     * @return string get the base URL for the XML RPC call
     */
    public function getUrl()
    {
        return ($this->live) ? self::URL_LIVE : self::URL_TEST;
    }

    /**
     * Return API Key (set in constructor)
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * First Part of XML RPC call
     * @return string
     * @throws GandiException
     */
    public function getPrefix()
    {
        if (!strlen($this->prefix)) {
            throw new GandiException(GandiException::ERROR_PREFIX_NOT_SET);
        }

        return $this->prefix;
    }
}
