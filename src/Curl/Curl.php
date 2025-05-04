<?php

namespace DennisCarrazeiro\Php\Curl\Module\Curl;

/**
 * Utility class to perform HTTP requests using the PHP cURL extension.
 * Offers a fluent interface to configure various request options.
 */
class Curl {

    /**
     * @var resource|false cURL handler. Stores the cURL instance after initialization.
     */
    private $ch;

    /**
     * @var string Target URL of the request.
     */
    private $url;

    /**
     * @var array List of HTTP headers to be sent in the request.
     */
    private $headers = [];

    /**
     * @var string User agent to be used in the request. Default value: "Curl/1.0".
     */
    private $userAgent = "Curl/1.0";

    /**
     * @var int Timeout in seconds for the request. Default value: 86400 (24 hours).
     */
    private $timeout = 86400;

    /**
     * @var bool Defines whether cURL should verify the hostname in the SSL certificate. Default value: false.
     */
    private $sslVerifyHost = false;

    /**
     * @var bool Defines whether cURL should verify the authenticity of the peer's SSL certificate. Default value: false.
     */
    private $sslVerifyPeer = false;

    /**
     * @var bool Defines whether the transfer should return the result as a string. Default value: false.
     */
    private $returnTransfer = false;

    /**
     * @var bool Defines whether cURL should follow location redirects (`Location` headers). Default value: false.
     */
    private $followLocation = false;

    /**
     * @var string Defines a custom HTTP method for the request (e.g., PUT, DELETE).
     */
    private $customRequest;

    /**
     * @var string HTTP authentication credentials in the format "username:password".
     */
    private $userPwd;

    /**
     * @var int HTTP status code of the last executed request.
     */
    private $statusCode;

    /**
     * @var string Body of the response from the last executed request.
     */
    private $responseBody;

    /**
     * @var array Data to be sent in the request body in case of the POST method.
     */
    private $postFields;

    /**
     * @var string Defines the Content-Type header of the request.
     */
    private $contentType;

    /**
     * @var array Array to store validation or cURL execution errors.
     */
    private $validations = [];

    /**
     * Constructor of the Curl class. Allows setting the default Content-Type of the request.
     *
     * @param string|null $contentType The content type to be sent in the 'Content-Type' header. Optional.
     */
    public function __construct($contentType = null){
        if(!is_null($contentType)){
            $this->contentType = $contentType;
            $this->addHeader(sprintf("Content-Type: %s",$this->contentType));
        }
    }

    /**
     * Sets the target URL of the request.
     *
     * @param string $url The URL to which the request will be made.
     * @return $this Returns the class instance itself to allow method chaining.
     */
    public function url($url){
        $this->url = $url;
        return $this;
    }

    /**
     * Sets the user agent to be used in the request.
     *
     * @param string $userAgent The user agent string.
     * @return $this Returns the class instance itself to allow method chaining.
     */
    public function userAgent(string $userAgent){
        $this->userAgent = $userAgent;
        return $this;
    }

    /**
     * Adds an HTTP header to the list of request headers.
     *
     * @param string $header The header string in the format "Name: Value".
     * @return $this Returns the class instance itself to allow method chaining.
     */
    public function addHeader(string $header){
        if($header){
            $this->headers[] = $header;
        } else {
            $this->headers = array();
        }
        return $this;
    }

    /**
     * Sets the timeout in seconds for the request.
     *
     * @param int $timeout The timeout in seconds.
     * @return $this Returns the class instance itself to allow method chaining.
     */
    public function timeOut(int $timeout){
        $this->timeout = $timeout;
        return $this;
    }

    /**
     * Sets whether the transfer should return the result as a string.
     *
     * @param bool $returnTransfer `true` to return the transfer result as a string, `false` to output directly.
     * @return $this Returns the class instance itself to allow method chaining.
     */
    public function returnTransfer(bool $returnTransfer){
        $this->returnTransfer = $returnTransfer;
        return $this;
    }

    /**
     * Sets the data to be sent in the request body in case of the POST method.
     * Can be an associative array or a string in query format (e.g., 'param1=value1&param2=value2').
     *
     * @param array|string $postFields The data to be sent in the request body.
     * @return $this Returns the class instance itself to allow method chaining.
     */
    public function postFields(array|string $postFields){
        $this->postFields = $postFields;
        return $this;
    }

    /**
     * Sets whether cURL should verify the hostname in the SSL certificate.
     *
     * @param bool $sslVerifyHost `true` to verify the hostname, `false` to ignore.
     * @return $this Returns the class instance itself to allow method chaining.
     */
    public function sslVerifyHost(bool $sslVerifyHost){
        $this->sslVerifyHost = $sslVerifyHost;
        return $this;
    }

    /**
     * Sets whether cURL should verify the authenticity of the peer's SSL certificate.
     *
     * @param bool $sslVerifyPeer `true` to verify the certificate, `false` to ignore.
     * @return $this Returns the class instance itself to allow method chaining.
     */
    public function sslVerifyPeer(bool $sslVerifyPeer){
        $this->sslVerifyPeer = $sslVerifyPeer;
        return $this;
    }

    /**
     * Sets whether cURL should follow location redirects (`Location` headers).
     *
     * @param bool $followLocation `true` to follow redirects, `false` not to follow.
     * @return $this Returns the class instance itself to allow method chaining.
     */
    public function followLocation(bool $followLocation){
        $this->followLocation = $followLocation;
        return $this;
    }

    /**
     * Sets the HTTP authentication credentials.
     *
     * @param string $userPwd The string with the credentials in the format "username:password".
     * @return $this Returns the class instance itself to allow method chaining.
     */
    public function userPwd(string $userPwd){
        $this->userPwd = $userPwd;
        return $this;
    }

    /**
     * Sets a custom HTTP method for the request (e.g., PUT, DELETE).
     *
     * @param string $customRequest The name of the custom HTTP method in uppercase (e.g., "PUT", "DELETE").
     * @return $this Returns the class instance itself to allow method chaining.
     */
    public function customRequest(string $customRequest){
        $this->customRequest = $customRequest;
        return $this;
    }

    /**
     * Returns the HTTP status code of the last executed request.
     *
     * @return int|null The HTTP status code or `null` if no request has been executed yet.
     */
    public function statusCode(){
        return $this->statusCode;
    }

    /**
     * Sets validation errors, used in the execution function.
     *
     * @param array $validationErrors array with errors that ocurrs in the execution of curl.
     * @return $this Returns the class instance itself to allow method chaining.
     */
    public function validationErrors(array $validationErrors){
        if($validationErrors){
            $this->validations['errors'] = $validationErrors;
        }
        return $this;
    }

    /**
     * Returns the validation or cURL execution errors, if any.
     *
     * @return array|false An array containing the error messages or `false` if there are no errors.
     */
    public function getValidationsErrors(){
        if(isset($this->validations['errors'])){
            return $this->validations['errors'];
        }
        return false;
    }

    /**
     * Executes the cURL request with the defined configurations.
     *
     * @return string|bool The response body on success (if `returnTransfer` is `true`),
     * `true` on success (if `returnTransfer` is `false`),
     * or `false` on cURL execution failure.
     */
    public function execute(){
        // Sets the execution time limit to avoid timeouts for long requests.
        set_time_limit(0);
        // Initializes a new cURL session.
        $this->ch = curl_init();
        // Sets the request URL.
        curl_setopt($this->ch, CURLOPT_URL, $this->url);
        // Sets a custom HTTP method, if specified.
        if($this->customRequest){
            curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, $this->customRequest);
        }
        // Sets the HTTP authentication credentials, if provided.
        if($this->userPwd){
            curl_setopt($this->ch, CURLOPT_USERPWD, $this->userPwd);
        }
        // Sets the user agent of the request.
        curl_setopt($this->ch, CURLOPT_USERAGENT, $this->userAgent);
        // Sets the request timeout.
        curl_setopt($this->ch, CURLOPT_TIMEOUT, $this->timeout);
        // Sets the HTTP headers, if any.
        if(is_array($this->headers) && !empty($this->headers)){
            curl_setopt($this->ch, CURLOPT_HTTPHEADER, $this->headers);
        }
        // Sets whether the transfer result should be returned as a string.
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, $this->returnTransfer);
        // Sets whether to verify the hostname in the SSL certificate.
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, $this->sslVerifyHost);
        // Sets whether to verify the authenticity of the peer's SSL certificate.
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, $this->sslVerifyPeer);
        // Configures the request as POST and sends the data, if any.
        if($this->postFields){
            curl_setopt($this->ch, CURLOPT_POST, 1);
            curl_setopt($this->ch, CURLOPT_POSTFIELDS, $this->postFields);
        }
        // Sets whether to follow location redirects.
        curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, $this->followLocation);
        // Gets the HTTP status code of the request.
        $this->statusCode = curl_getinfo($this->ch, CURLINFO_HTTP_CODE);
        // Executes the cURL request and gets the response body.
        $this->responseBody = curl_exec($this->ch);
        // Checks if there was any error during the cURL execution.
        if($this->responseBody === false) {
            $errors = sprintf("Curl error: %s", curl_error($this->ch));
            $this->validationErrors($errors);
        }
        // Closes the cURL session.
        curl_close($this->ch);
        // Returns the response body or the execution result.
        return $this->responseBody;
    }

}