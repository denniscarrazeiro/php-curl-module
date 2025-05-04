<?php

require_once(__DIR__."/../vendor/autoload.php");

use \DennisCarrazeiro\Php\Curl\Module\Curl\Curl;

$curl = new Curl();
$response = $curl->url('https://api.example.com/users')
                 ->returnTransfer(true) // Returns the response as a string
                 ->execute();

if ($curl->statusCode() === 200) {
    echo "Successful GET request!\n";
    // Process the response (usually in JSON)
    $data = json_decode($response, true);
    print_r($data);
} else {
    echo "GET request failed. Status code: " . $curl->statusCode() . "\n";
    if ($errors = $curl->getValidationsErrors()) {
        echo "Error details: " . implode(", ", $errors) . "\n";
    }
}