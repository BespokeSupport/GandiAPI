<?php

require_once '_bootstrap.php';


$oGandi = new \BespokeSupport\Gandi\GandiAPITest(GANDI_TEST_API_KEY);

try {

    /*
     * version.info()
     */
    $result = $oGandi->version->info();

} catch (\BespokeSupport\Gandi\GandiException $e) {
    echo 'EXCEPTION'.PHP_EOL;
    echo $e->getMessage().PHP_EOL;
    $result = array();
}

var_dump($result);
