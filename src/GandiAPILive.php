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
 * Class GandiAPILive
 * @package BespokeSupport\Gandi
 */
class GandiAPILive extends GandiAPI
{
    /**
     * Extends main GandiAPI class
     * @param string|null $apiKey API Key (https://www.gandi.net/admin/api_key)
     * @throws GandiException
     */
    public function __construct($apiKey = null)
    {
        parent::__construct($apiKey, true);
    }
}
