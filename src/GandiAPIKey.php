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
 * Class GandiAPIKey
 * @package BespokeSupport\Gandi
 */
class GandiAPIKey
{
    /**
     * @var string
     */
    private $apiKey;

    /**
     * @param null|string $apiKey String of the API Key
     * @throws GandiException
     */
    public function __construct($apiKey = null)
    {
        if (!preg_match('/^[a-zA-Z0-9]{24}$/', $apiKey)) {
            throw new GandiException(GandiException::ERROR_API_KEY_INVALID);
        }

        $this->apiKey = $apiKey;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->apiKey;
    }
}