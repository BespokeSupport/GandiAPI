<?php

namespace BespokeSupport\Gandi\Test;

use BespokeSupport\Gandi\GandiAPI;
use BespokeSupport\Gandi\GandiAPILive;
use BespokeSupport\Gandi\GandiAPITest;
use BespokeSupport\Gandi\GandiException;

class DefaultTest extends \PHPUnit_Framework_TestCase
{
    const API_KEY_INVALID = 'test';

    const API_VERSION = '3.3.24';

    /**
     *
     */
    static function setUpBeforeClass()
    {
        if (file_exists(dirname(__FILE__).'/../credentials.php')) {
            include_once dirname(__FILE__).'/../credentials.php';
        }
    }

    public static function getApiKey()
    {
        if (defined('GANDI_TEST_API_KEY')) {
            return GANDI_TEST_API_KEY;
        } else if (getenv('GANDI_API_KEY')) {
            return getenv('GANDI_API_KEY');
        } else {
            throw new \Exception('define GANDI_TEST_API_KEY in new credentials.php script');
        }
    }

    public function testErrorNoApiKey()
    {
        try {
            $oGandi = new GandiAPI();
            $this->assertTrue(false);
        } catch (GandiException $e) {
            $this->assertTrue(true);
            $this->assertEquals(GandiException::ERROR_API_KEY_INVALID, $e->getMessage());
        }
    }

    public function testErrorApiKeyInvalid()
    {
        try {
            $oGandi = new GandiAPITest(self::API_KEY_INVALID);
            $this->assertTrue(false);
        } catch (GandiException $e) {
            $this->assertTrue(true);
            $this->assertEquals(GandiException::ERROR_API_KEY_INVALID, $e->getMessage());
        }
    }

    public function testErrorNoMethodSet()
    {
        try {
            $oGandi = new GandiAPITest(self::getApiKey());
            $oGandi->version();
            $this->assertTrue(false);
        } catch (GandiException $e) {
            $this->assertTrue(true);
            $this->assertEquals(GandiException::ERROR_PREFIX_NOT_SET, $e->getMessage());
        }
    }

    public function testLiveTestClasses()
    {
        $oGandi = new GandiAPILive(self::getApiKey());
        $oGandi = new GandiAPITest(self::getApiKey());
        $this->assertTrue(true);
    }

    public function testInstantiateTest()
    {
        $oGandi = new GandiAPI(self::getApiKey());

        $this->assertEquals(self::getApiKey(), $oGandi->getApiKey());
        $this->assertEquals(GandiAPI::URL_TEST, $oGandi->getUrl());
        $this->assertFalse($oGandi->live);
    }
}
