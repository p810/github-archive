<?php

namespace p810\HTTP;

class Request
{
    /**
     * An associative array of headers belonging to the request.
     *
     * @var array
     * @access protected
     */
    protected $headers;


    /**
     * An associative array of query parameters belonging to the request.
     *
     * @var array
     * @access protected
     */
    protected $parameters;


    /**
     * Stores the client's IP address.
     *
     * @var string
     * @access public
     */
    public $address;


    /**
     * Fills the object with data belonging to the request.
     *
     * @return void
     */
    function __construct()
    {
        $this->headers    = $this->getRequestHeaders();
        $this->parameters = $this->getQueryParameters();
        $this->address    = $this->getIPAddress();
    }


    /**
     * Retrieves a header or query parameter value by its name.
     *
     * @param string $method The method being called, either `getHeader()` or `getQueryParameter()`.
     * @param array $arguments The value to access.
     *
     * @throws InvalidArgumentException If the method is not one of either `getHeader()` or `getQueryParameter()`, or if no arguments are passed to the call.
     * @throws OutOfBoundsException If the value does not belong to either Request::$headers or Request::$parameters.
     *
     * @return mixed
     */ 
    function __call($method, $arguments)
    {
        if (count($arguments) !== 1) {
            throw new \InvalidArgumentException('Calling getHeader() or getQueryParameter() requires at least one argument');
        }

        switch ($method) {
            case 'getHeader':
                $response = $this->getValue($arguments[0], $this->headers);
            break;

            case 'getQueryParameter':
                $response = $this->getValue($arguments[0], $this->parameters);
            break;

            default:
                return false;
            break;
        }

        return $response;
    }


    /**
     * Retrieve a header. If none is found null is returned.
     *
     * @param string|array $name The name(s) of the value(s) to get.
     */
    private function getValue($name, $array)
    {
        if (is_array($name)) {
            $return = array();

            foreach ($name as $key) {
                $return[] = $array[$key];
            }

            return $return;
        }

        return @$array[$key];
    }

    
    /**
     * Returns the HTTP headers belonging to the current request.
     *
     * @throws Exception if the call to getallheaders() failed.
     * @see <http://php.net/manual/en/function.getallheaders.php>
     * @return array
     */
    protected function getRequestHeaders()
    {
        $headers = getallheaders();

        if (!$headers) {
            throw new \Exception('Call to getallheaders() returned false');
        }

        return $headers;
    }

    
    /**
     * Returns the query parameters belonging to the current request.
     * 
     * @return array
     */
    protected function getQueryParameters()
    {
        return $_GET;
    }

    
    /**
     * Returns the IP address of the client of the current request.
     *
     * @return string
     */
    protected function getIPAddress()
    {
        return $_SERVER['REMOTE_ADDR'];
    }
}