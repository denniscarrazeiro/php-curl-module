<?php

namespace DennisCarrazeiro\Php\Curl\Module\Curl\Tests;

use \DennisCarrazeiro\Php\Curl\Module\Curl\Curl;
use \PHPUnit\Framework\TestCase;

/**
 * @covers \DennisCarrazeiro\Php\Curl\Module\Curl\Curl
 */
class CurlTest extends TestCase
{
    /**
     * @var Curl $curl The Curl instance used for testing.
     */
    private $curl;

    /**
     * Sets up the test environment before each test.
     * Creates a new Curl instance with a default Content-Type of 'application/json'.
     *
     * @return void
     */
    protected function setUp(): void
    {
        $this->curl = new Curl('application/json');
    }

    /**
     * Tests the `url()` method of the Curl class.
     * It asserts that the method returns the same instance of the Curl object,
     * allowing for method chaining.
     *
     * @return void
     */
    public function testSetUrl(): void
    {
        $selfObject = $this->curl->url("https://example.com");
        $this->assertEquals($selfObject, $this->curl);
    }

    /**
     * Tests the `userAgent()` method of the Curl class.
     * It asserts that the method returns the same instance of the Curl object,
     * allowing for method chaining.
     *
     * @return void
     */
    public function testSetUserAgent(): void
    {
        $selfObject = $this->curl->userAgent("Google Chrome");
        $this->assertEquals($selfObject, $this->curl);
    }

    /**
     * Tests the `addHeader()` method of the Curl class.
     * It asserts that the method returns the same instance of the Curl object,
     * allowing for method chaining, both when adding a valid header array
     * and when adding a null value (which should not add a header).
     *
     * @return void
     */
    public function testSetAddHeader(): void
    {
        $selfObject = $this->curl->addHeader(["x-app-id" => "123"]);
        $this->assertEquals($selfObject, $this->curl);
        $selfObject = $this->curl->addHeader(null);
        $this->assertEquals($selfObject, $this->curl);
    }

    /**
     * Tests the `timeOut()` method of the Curl class.
     * It asserts that the method returns the same instance of the Curl object,
     * allowing for method chaining.
     *
     * @return void
     */
    public function testSetTimeout(): void
    {
        $selfObject = $this->curl->timeOut(1);
        $this->assertEquals($selfObject, $this->curl);
    }

    /**
     * Tests the `returnTransfer()` method of the Curl class.
     * It asserts that the method returns the same instance of the Curl object,
     * allowing for method chaining.
     *
     * @return void
     */
    public function testSetReturnTransfer(): void
    {
        $selfObject = $this->curl->returnTransfer(true);
        $this->assertEquals($selfObject, $this->curl);
    }

    /**
     * Tests the `postFields()` method of the Curl class.
     * It asserts that the method returns the same instance of the Curl object,
     * allowing for method chaining.
     *
     * @return void
     */
    public function testSetPostFields(): void
    {
        $selfObject = $this->curl->postFields(['name'=>'xyz']);
        $this->assertEquals($selfObject, $this->curl);
    }

    /**
     * Tests the `sslVerifyHost()` method of the Curl class.
     * It asserts that the method returns the same instance of the Curl object,
     * allowing for method chaining.
     *
     * @return void
     */
    public function testSetSslVerifyHost(): void
    {
        $selfObject = $this->curl->sslVerifyHost(true);
        $this->assertEquals($selfObject, $this->curl);
    }

    /**
     * Tests the `sslVerifyPeer()` method of the Curl class.
     * It asserts that the method returns the same instance of the Curl object,
     * allowing for method chaining.
     *
     * @return void
     */
    public function testSetSslVerifyPeer(): void
    {
        $selfObject = $this->curl->sslVerifyPeer(true);
        $this->assertEquals($selfObject, $this->curl);
    }

    /**
     * Tests the `followLocation()` method of the Curl class.
     * It asserts that the method returns the same instance of the Curl object,
     * allowing for method chaining.
     *
     * @return void
     */
    public function testSetFollowLocation(): void
    {
        $selfObject = $this->curl->followLocation(true);
        $this->assertEquals($selfObject, $this->curl);
    }

    /**
     * Tests the `userPwd()` method of the Curl class.
     * It asserts that the method returns the same instance of the Curl object,
     * allowing for method chaining.
     *
     * @return void
     */
    public function testSetUserPwd(): void
    {
        $selfObject = $this->curl->userPwd("username:password");
        $this->assertEquals($selfObject, $this->curl);
    }

    /**
     * Tests the `statusCode()` method of the Curl class when setting a status code.
     * It asserts that the method returns the same instance of the Curl object,
     * allowing for method chaining. Note: This test only checks the setter;
     * the actual retrieval of the status code after an execution would be tested elsewhere.
     *
     * @return void
     */
    public function testSetStatusCode(): void
    {
        $selfObject = $this->curl->statusCode(200);
        $this->assertEquals($selfObject, $this->curl);
    }

    /**
     * Tests the `validationErrors()` method of the Curl class when setting validation errors.
     * It asserts that the method returns the same instance of the Curl object,
     * allowing for method chaining. Note: This test only checks the setter;
     * the actual retrieval of validation errors would be tested elsewhere.
     *
     * @return void
     */
    public function testSetValidationsErrors(): void
    {
        $selfObject = $this->curl->validationErrors(['status'=>'Not found url.']);
        $this->assertEquals($selfObject, $this->curl);
    }

    /**
     * Tests the `getValidationsErrors()` method of the Curl class.
     * It first sets validation errors to null and asserts that `getValidationsErrors()` returns false.
     * Then, it sets a mock array of validation errors and asserts that `getValidationsErrors()`
     * returns this mock array.
     *
     * @return void
     */
    public function testGetValidationsErrors(): void
    {
        $mockedValidationErrors = ['status'=>'Not found url.'];
        $this->curl->validationErrors(null);
        $this->assertEquals(false,  $this->curl->getValidationsErrors());
        $this->curl->validationErrors($mockedValidationErrors);
        $this->assertEquals($mockedValidationErrors,  $this->curl->getValidationsErrors());

    }

    /**
     * Tests the `customRequest()` method of the Curl class.
     * It asserts that the method returns the same instance of the Curl object,
     * allowing for method chaining.
     *
     * @return void
     */
    public function testSetCustomRequest(): void
    {
        $selfObject = $this->curl->customRequest("GET");
        $this->assertEquals($selfObject, $this->curl);
    }

    /**
     * Tests the `execute()` method of the Curl class.
     * This test sets up a basic configuration with a custom request, user credentials,
     * and post fields, then asserts that the `execute()` method returns true.
     * Note: This is a basic test and might need more sophisticated mocking
     * to ensure actual HTTP requests are handled correctly in different scenarios.
     *
     * @return void
     */
    public function testExecute(): void
    {
        $this->curl->customRequest("GET");
        $this->curl->userPwd("username:password");
        $this->curl->postFields(['name'=>'xyz']);
        $this->assertEquals(true,$this->curl->execute());
    }

}