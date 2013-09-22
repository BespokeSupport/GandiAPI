<?php
/**
 * This file is part of the GandiAPI PHP Class.
 *
 * PHP Version 5
 *
 * @category API
 * @package  RickSeymourGandiAPI
 * @author   Rick Seymour <code@rickseymour.com>
 * @license  http://creativecommons.org/licenses/by/3.0/deed.en_GB CC-By
 * @link     https://github.com/RickSeymour/GandiAPI
 */

namespace GandiAPI;

require_once 'XML/RPC2/Client.php';

/**
 * Class GandiAPI
 *
 * @category API
 * @package  RickSeymourGandiAPI
 * @author   Rick Seymour <code@rickseymour.com>
 * @license  http://creativecommons.org/licenses/by/3.0/deed.en_GB CC-By
 * @link     https://github.com/RickSeymour/GandiAPI
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
     * @var string
     */
    public $urlEndpoint;

    /**
     * @var bool
     */
    public $live = false;

    /**
     * @var string|null
     */
    public $apikey;

    /**
     * @var string
     */
    public $prefix = 'version';

    /**
     * Instantiates class
     *
     * @param string $apiKey API Key (https://www.gandi.net/admin/api_key)
     * @param bool   $live   from parent class
     *
     * @throws \Exception
     */
    function __construct($apiKey, $live = false)
    {
        switch ($live) {
        case true:
                $this->live = true;
                $this->urlEndpoint = self::URL_LIVE;
            break;
        default:
                $this->urlEndpoint = self::URL_TEST;
            break;
        }
        if (strlen($apiKey)) {
            $this->apikey = $apiKey;
        } else {
            throw new \Exception('GandiAPI: apikey required');
        }
        $this->live = $live;
    }

    /**
     * Allows for chaining of api prefix
     *
     * @param string $property API Section
     *
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

        $xml = \XML_RPC2_Client::create(
            $this->urlEndpoint,
            array(
                'sslverify' => false,
                'prefix' => $this->prefix . '.'
            )
        );

        if (isset($args[1])) {
            return $xml->__call(
                $method,
                array(
                    $this->apikey,
                    $args[0],
                    $args[1]
                )
            );
        } elseif (isset($args[0])) {
            return $xml->__call(
                $method,
                array(
                    $this->apikey,
                    $args[0]
                )
            );
        } else {
            return $xml->__call(
                $method,
                array(
                    $this->apikey
                )
            );
        }
    }
}
