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
 * Class GandiAPITest
 * @package BespokeSupport\Gandi
 */
class GandiAPITest extends GandiAPI
{
    /**
     * Extends main GandiAPI class
     * @param null $apiKey API Key (https://www.gandi.net/admin/api_key)
     * @throws GandiException
     */
    public function __construct($apiKey = null)
    {
        parent::__construct($apiKey, false);
    }
}
