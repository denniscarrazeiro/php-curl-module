<?php

require_once(__DIR__."/../vendor/autoload.php");

use \DennisCarrazeiro\Php\Curl\Module\Curl\Curl;

$curl = new Curl();
$response = $curl->url('https://protected.example.com/data')
                 ->userPwd('username:password') // Sets the authentication credentials
                 ->returnTransfer(true)
                 ->execute();

if ($curl->statusCode() === 200) {
    echo "Successfully accessed protected data!\n";
    echo $response . "\n";
} else {
    echo "Error accessing protected data. Status code: " . $curl->statusCode() . "\n";
    if ($errors = $curl->getValidationsErrors()) {
        echo "Error details: " . implode(", ", $errors) . "\n";
    }
}