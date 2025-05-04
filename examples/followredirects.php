<?php

require_once(__DIR__."/../vendor/autoload.php");

use \DennisCarrazeiro\Php\Curl\Module\Curl\Curl;

$curl = new Curl();
$response = $curl->url('https://example.com/old-url') // Assuming this URL redirects
                 ->followLocation(true) // Enables following redirects
                 ->returnTransfer(true)
                 ->execute();

if ($curl->statusCode() === 200) {
    echo "Successful request after following redirect.\n";
    echo $response . "\n";
} else {
    echo "Error in request or redirect. Status code: " . $curl->statusCode() . "\n";
    // ... error handling ...
}