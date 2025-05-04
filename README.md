# PHP Curl Module

[![Maintainer](http://img.shields.io/badge/maintainer-denniscarrazeiro-blue.svg?style=flat-square)](https://www.linkedin.com/in/dennis-carrazeiro)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/denniscarrazeiro/php-curl-module.svg?style=flat-square)](https://packagist.org/packages/denniscarrazeiro/php-curl-module)
[![Latest Version](https://img.shields.io/github/release/denniscarrazeiro/php-curl-module.svg?style=flat-square)](https://github.com/denniscarrazeiro/php-curl-module/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)

The Php Curl Module provides a robust and flexible way to perform HTTP requests within PHP applications, leveraging the power of the cURL extension. Through its intuitive fluent interface, developers can effortlessly configure a wide range of request options, including the target URL, custom HTTP headers, user agent, timeout settings, SSL verification preferences, data for POST requests, HTTP authentication credentials, and even define custom HTTP methods like PUT or DELETE. This class simplifies the process of interacting with web services and APIs, enabling seamless data retrieval and submission with granular control over the underlying HTTP communication.

## Instalation

```bash
bash ./scripts/composer_install.sh
```

Composer is a dependency manager for the PHP programming language. Therefore, after running the command above, Composer will install all the necessary dependencies to ensure the project functions under the best possible conditions.

## Unit Tests

```bash
bash ./scripts/phpunit_tests.sh
```

PHPUnit is a programmer-oriented testing framework for PHP, designed to facilitate the creation and execution of unit tests. Consequently, after setting up your test suite and running the appropriate command, PHPUnit will execute your tests and provide detailed feedback, ensuring your codebase maintains a high level of quality and reliability.

#### Usage Example 1

```php

require 'Curl.php'; // Make sure to include the Curl class file

use DennisCarrazeiro\Php\Curl\Module\Curl\Curl;

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

```

#### Usage Example 2

```php

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

```

## More Examples

For more examples see the [Examples](https://github.com/denniscarrazeiro/php-curl-module/blob/master/examples) folder.

## License

The MIT license. Please see [License file](https://github.com/denniscarrazeiro/php-curl-module/blob/master/LICENSE) for more information.