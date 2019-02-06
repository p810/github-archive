<?php

namespace p810\Amethyst\HTTP;

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
     * @param string $method The method being called, either `header()` or `parameter()`.
     * @param array $arguments The value to access.
     *
     * @throws InvalidArgumentException If the method is not one of either `header()` or `parmaeter()`, or if no arguments are passed to the call.
     * @throws OutOfBoundsException If the value does not belong to either Request::$headers or Request::$parameters.
     *
     * @return mixed
     */ 
    function __call($method, $arguments)
    {
        if (!in_array($method, ['header', 'parameter'])) {
            throw new \InvalidArgumentException($method . ' is not a valid method to HTTP\Request');
        }

        if (count($arguments) === 0) {
            throw new \InvalidArgumentException('At least one argument must be supplied to HTTP\Request::' . $method);
        }

        $array = $method . 's';

        if (!array_key_exists($arguments[0], $this->$array)) {
            throw new \OutOfBoundsException( sprintf('The key %s is undefined in HTTP\Request::%s', $arguments[0], $array) );
        }

        $array = $this->$array;

        return $array[ $arguments[0] ];
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