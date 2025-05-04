<?php

require_once(__DIR__."/../vendor/autoload.php");

use \DennisCarrazeiro\Php\Curl\Module\Curl\Curl;


$curl = new Curl();
$responseBody = $curl->url('https://viacep.com.br/ws/01001000/json/')
						->returnTransfer(true)
						->customRequest('GET')
						->execute();
echo "<pre>";
echo print_r(json_decode($responseBody,true));
echo "</pre>";