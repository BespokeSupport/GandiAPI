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
     * @var string api section being used
     */
    protected $prefix = '';

    /**
     * @var string
     */
    protected $method = '';

    /**
     * @var
     */
    protected $calledMethod;

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
        $this->apiKey = new GandiAPIKey($apiKey);

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

            if ($this->calledMethod) {
                $this->resetPrefix();
            }

            $this->prefix .= $property;
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

        $this->method = $method;

        $this->calledMethod = $this->getCompleteMethod();

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

        $callArray = array();

        if (GandiAPIMethodRequirements::isApiKeyRequired($this->calledMethod)) {
            $callArray[] = $this->getApiKey();
        }

        foreach ($args as $a) {
            $callArray[] = $a;
        }

        try {
            $apiResult = $xml->__call($this->method, $callArray);
        } catch (\XML_RPC2_CurlException $e) {
            // @codeCoverageIgnoreStart
            $apiResult = array();
            // @codeCoverageIgnoreEnd
        }

        return $apiResult;
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
        return (string)$this->apiKey;
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

    /**
     * @return string
     * @throws GandiException
     */
    public function getCompleteMethod()
    {
        return $this->getPrefix().'.'.$this->method;
    }

    /**
     * @return $this
     */
    public function resetPrefix()
    {
        $this->prefix = '';
        return $this;
    }
}
