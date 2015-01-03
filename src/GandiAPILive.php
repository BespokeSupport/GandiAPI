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

namespace BespokeSupport\Gandi;

/**
 * Class GandiAPILive
 *
 * @category API
 * @package  RickSeymourGandiAPI
 * @author   Rick Seymour <code@rickseymour.com>
 * @license  http://creativecommons.org/licenses/by/3.0/deed.en_GB CC-By
 * @link     https://github.com/RickSeymour/GandiAPI
 */
class GandiAPILive extends GandiAPI
{
    /**
     * Extends main GandiAPI class
     *
     * @param string $apiKey API Key (https://www.gandi.net/admin/api_key)
     */
    function __construct($apiKey)
    {
        parent::__construct($apiKey, true);
    }
}
