<?php

require_once '_bootstrap.php';


$oGandi = new \BespokeSupport\Gandi\GandiAPITest(GANDI_TEST_API_KEY);

try {

    /*
     * system.methodHelp()
     */
    $result = $oGandi->system->methodHelp('domain.list');

} catch (\BespokeSupport\Gandi\GandiException $e) {
    echo 'EXCEPTION'.PHP_EOL;
    echo $e->getMessage().PHP_EOL;
    $result = array();
}

var_dump($result);
