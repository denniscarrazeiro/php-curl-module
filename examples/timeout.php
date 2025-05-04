<?php

require_once(__DIR__."/../vendor/autoload.php");

use \DennisCarrazeiro\Php\Curl\Module\Curl\Curl;

$curl = new Curl();
$response = $curl->url('https://slow.example.com/resource')
                 ->timeOut(5) // Sets a timeout of 5 seconds
                 ->returnTransfer(true)
                 ->execute();

if ($response !== false) {
    echo "Response received (within timeout):\n";
    echo $response . "\n";
} else {
    echo "Request timed out.\n";
    if ($errors = $curl->getValidationsErrors()) {
        echo "Error details: " . implode(", ", $errors) . "\n";
    }
}