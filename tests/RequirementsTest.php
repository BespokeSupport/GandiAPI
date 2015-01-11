<?php

namespace BespokeSupport\Gandi\Test;

use BespokeSupport\Gandi\GandiAPI;
use BespokeSupport\Gandi\GandiAPILive;
use BespokeSupport\Gandi\GandiAPIMethodRequirements;
use BespokeSupport\Gandi\GandiAPITest;
use BespokeSupport\Gandi\GandiException;

class RequirementsTest extends \PHPUnit_Framework_TestCase
{
    public function testInitial()
    {
        $requirements = new GandiAPIMethodRequirements();

        $tested = array();
        foreach (GandiAPIMethodRequirements::$methods as $m) {

            $items = explode('.', $m);
            $method = $items[count($items)-1];
            unset($items[count($items)-1]);
            $prefix = implode('.', $items);

            $avail = $requirements->prefixAvailable($prefix);

            $this->assertNotEmpty($method);
            $this->assertTrue($avail);

            if (!in_array($prefix, $tested)) {
                $tested[] = $prefix;
            }
        }

        $this->assertCount(count($tested), GandiAPIMethodRequirements::$prefixes);

        foreach (GandiAPIMethodRequirements::$prefixes as $p) {
            $test = (in_array($p, $tested)) ? false : $p;
            $this->assertFalse($test);
        }
    }

    public function testApiRequired()
    {
        $this->assertFalse(GandiAPIMethodRequirements::isApiKeyRequired('system.listMethods'));
        $this->assertTrue(GandiAPIMethodRequirements::isApiKeyRequired('contact.balance'));
    }
}
