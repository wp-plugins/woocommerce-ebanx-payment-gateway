<?php
/**
 * Copyright (c) 2013, EBANX Tecnologia da Informação Ltda.
 *  All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *
 * Redistributions of source code must retain the above copyright notice, this
 * list of conditions and the following disclaimer.
 *
 * Redistributions in binary form must reproduce the above copyright notice,
 * this list of conditions and the following disclaimer in the documentation
 * and/or other materials provided with the distribution.
 *
 * Neither the name of EBANX nor the names of its
 * contributors may be used to endorse or promote products derived from
 * this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE
 * FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
 * DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
 * SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY,
 * OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

namespace Ebanx\Http;

use Ebanx\Config;

/**
 * HTTP client class, wrapper for curl_* functions
 *
 * @author Gustavo Henrique Mascarenhas Machado gustavo@ebanx.com
 */
class Client
{
    /**
     * The cURL resource
     * @var resource
     */
    protected $curl;

    /**
     * The request HTTP method
     * @var string
     */
    protected $method;

    /**
     * The allowed HTTP methods
     * @var array
     */
    protected $allowedMethods = array('POST', 'GET');

    /**
     * The HTTP action (URI)
     * @var string
     */
    protected $action;

    /**
     * The request parameters
     * @var array
     */
    protected $params;

    /**
     * Flag to call json_decode on response
     * @var boolean
     */
    protected $decodeResponse = false;

    /**
     * Set the request parameters
     * @param array $params The request parameters
     * @return Ebanx\Http\Client
     */
    public function setParams($params)
    {
        $this->params = $params;
        $this->params['integration_key'] = Config::getIntegrationKey();

        return $this;
    }

    /**
     * Set the request HTTP method
     * @param string $method The request HTTP method
     * @return Ebanx\Http\Client
     * @throws InvalidArgumentException
     */
    public function setMethod($method)
    {
        if (!in_array(strtoupper($method), $this->allowedMethods))
        {
          throw new \InvalidArgumentException("The HTTP Client doesn't accept $method requests.");
        }

        $this->method = $method;
        return $this;
    }

    /**
     * Set the request target URI
     * @param string $action The target URI
     * @return Ebanx\Http\Client
     */
    public function setAction($action)
    {
        $this->action = Config::getURL() . $action;
        return $this;
    }

    /**
     * Set the decodeResponse flag depending on the response type (JSON or HTML)
     * @param string $responseType The response type (JSON or HTML)
     * @return Ebanx\Http\Client
     */

    public function setResponseType($responseType)
    {
        if (strtoupper($responseType) == 'JSON')
        {
            $this->decodeResponse = true;
        }

        return $this;
    }

    /**
     * Sends the HTTP request
     * @return StdClass
     */
    public function send()
    {
        $this->_setupCurl();

        $response = curl_exec($this->curl);

        if (curl_getinfo($this->curl, CURLINFO_HTTP_CODE) === 200)
        {
            // Decode JSON responses
            if ($this->decodeResponse)
            {
                $response = json_decode($response);
            }
        }
        else
        {
            if (curl_errno($this->curl))
            {
                throw new \RuntimeException('The HTTP request failed: ' . curl_error($this->curl));
            }
            else
            {
                throw new \RuntimeException('The HTTP request failed: unknown error.');
            }
        }

        curl_close($this->curl);

        return $response;
    }

    /**
     * Initialize the cURL resource
     * @return void
     */
    protected function _setupCurl()
    {
        $params = http_build_query($this->params);

        // POST requests
        if ($this->method == 'POST')
        {
            $this->curl = curl_init($this->action);
            curl_setopt($this->curl, CURLOPT_POST, true);
            curl_setopt($this->curl, CURLOPT_POSTFIELDS, $params);
        }
        // GET requests
        else if ($this->method == 'GET')
        {
            $this->curl = curl_init($this->action . '?' . $params);
        }

        // We want to receive the returned data
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);

        // Setup custom user agent
         curl_setopt($this->curl, CURLOPT_USERAGENT, 'EBANX PHP Library ' . \Ebanx\Ebanx::VERSION);
    }
}