<?php

namespace BespokeSupport\Gandi\Test;

use BespokeSupport\Gandi\GandiAPI;
use BespokeSupport\Gandi\GandiAPILive;
use BespokeSupport\Gandi\GandiAPITest;
use BespokeSupport\Gandi\GandiException;

class DefaultTest extends \PHPUnit_Framework_TestCase
{
    const API_KEY = 'test';

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

    private function getApiKey()
    {
        if (defined('GANDI_TEST_API_KEY')) {
            return GANDI_TEST_API_KEY;
        } else {
            return self::API_KEY;
        }
    }


    public function testErrorInstantiate()
    {
        try {
            $oGandi = new GandiAPI();
            $this->assertTrue(false);
        } catch (\Exception $e) {
            $this->assertTrue(true);
        }
    }
    public function testLiveTestClasses()
    {
        $oGandi = new GandiAPILive($this->getApiKey());
        $oGandi = new GandiAPITest($this->getApiKey());
        $this->assertTrue(true);
    }

    public function testInstantiateTest()
    {
        $oGandi = new GandiAPI($this->getApiKey());

        $this->assertEquals($this->getApiKey(), $oGandi->apikey);
        $this->assertEquals(GandiAPI::URL_TEST, $oGandi->urlEndpoint);
        $this->assertFalse($oGandi->live);
        $this->assertEquals('version', $oGandi->prefix);
    }

    public function testApiVersion()
    {
        $oGandi = new GandiAPITest($this->getApiKey());
        $result = $oGandi->info();
        $this->assertArrayHasKey('api_version', $result);
        $this->assertEquals($result['api_version'], self::API_VERSION);
    }


    public function testApiSystem()
    {
        $oGandi = new GandiAPITest($this->getApiKey());
        $result = $oGandi->domain->available(array('google.com'));
        $this->assertArrayHasKey('google.com', $result);
        $this->assertTrue(in_array($result['google.com'], array('pending', 'unavailable')));

        $result = $oGandi->domain->available(array('google.com'),array('phase' => 'open'));
        $this->assertArrayHasKey('google.com', $result);
        $this->assertTrue(in_array($result['google.com'], array('pending', 'unavailable')));
    }

    public function testApiTwoMethod()
    {
        $oGandi = new GandiAPITest($this->getApiKey());
        $result = $oGandi->hostingIp->count();
        $this->assertEquals('0', $result);
        $result = $oGandi->hosting->ipCount();
        $this->assertEquals('0', $result);
    }


    public function testErrorParam()
    {
//        $oGandi = new GandiAPITest($this->getApiKey());
//        $result = $oGandi->domain->available(array('google.com'),array('phase' => 'open'));

    }
}
