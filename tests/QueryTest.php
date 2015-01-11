<?php

namespace BespokeSupport\Gandi\Test;

use BespokeSupport\Gandi\GandiAPITest;

class QueryTest extends \PHPUnit_Framework_TestCase
{
    public function testApiVersion()
    {
        $oGandi = new GandiAPITest(DefaultTest::getApiKey());
        $result = $oGandi->version->info();
        $this->assertEquals('version', $oGandi->getPrefix());
        $this->assertArrayHasKey('api_version', $result);
        $this->assertEquals($result['api_version'], DefaultTest::API_VERSION);
    }


    public function testApiSystem()
    {
        $oGandi = new GandiAPITest(DefaultTest::getApiKey());
        $result = $oGandi->domain->available(array('google.com'));
        $this->assertArrayHasKey('google.com', $result);
        $this->assertTrue(in_array($result['google.com'], array('pending', 'unavailable')));

        $result = $oGandi->domain->available(array('google.com'),array('phase' => 'open'));
        $this->assertArrayHasKey('google.com', $result);
        $this->assertTrue(in_array($result['google.com'], array('pending', 'unavailable')));
    }

    public function testApiTwoMethod()
    {
        $oGandi = new GandiAPITest(DefaultTest::getApiKey());
        $result = $oGandi->hostingIp->count();
        $this->assertEquals('0', $result);
    }


    public function testErrorParam()
    {
        $oGandi = new GandiAPITest(DefaultTest::getApiKey());
        $result = $oGandi->domain->available(array('google.com'),array('phase' => 'open'));
    }
}
