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
 * Class GandiException
 * @package BespokeSupport\Gandi
 */
class GandiException extends \Exception
{
    const ERROR_API_KEY_REQUIRED = 'GandiAPI: API Key required';
    const ERROR_API_KEY_INVALID  = 'GandiAPI: API Key invalid length (24)';
    const ERROR_PREFIX_NOT_SET  = 'GandiAPI: API Method not set';
}
