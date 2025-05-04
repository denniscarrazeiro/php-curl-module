<?php

require_once(__DIR__."/../vendor/autoload.php");

use \DennisCarrazeiro\Php\Curl\Module\Curl\Curl;

$data = [
    'name' => 'New User',
    'email' => 'new.user@example.com'
];
$jsonData = json_encode($data);

$curl = new Curl('application/json'); // Sets the Content-Type in the constructor
$response = $curl->url('https://api.example.com/users')
                 ->customRequest('POST') // Sets the method to POST
                 ->postFields($jsonData) // Sends the JSON data in the body
                 ->addHeader('X-API-Key: your_api_key') // Adds a custom header
                 ->returnTransfer(true)
                 ->execute();

if ($curl->statusCode() === 201) { // Status code 201 usually indicates successful creation
    echo "User created successfully!\n";
    $responseData = json_decode($response, true);
    print_r($responseData);
} else {
    echo "Error creating user. Status code: " . $curl->statusCode() . "\n";
    if ($errors = $curl->getValidationsErrors()) {
        echo "Error details: " . implode(", ", $errors) . "\n";
    }
}