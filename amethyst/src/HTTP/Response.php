<?php

namespace p810\Amethyst\HTTP;

class Response
{
    /**
     * Data to be sent to the client.
     *
     * @access protected
     * @var string|array|object
     */
    protected $data;


    /**
     * A boolean flag telling whether to encode the response body in JSON format.
     *
     * @access protected
     * @var boolean
     */
    protected $json;


    /**
     *The HTTP status code to associate with the response.
     *
     * @access protected
     * @var integer
     */
    protected $status;

    
    /**
     * Creates an instance of the class and may encode the response body in JSON format if told to.
     *
     * @param string|array|object $data Data to send with the response (the body).
     * @param boolean $json Whether or not to encode the response body in JSON format.
     * @param integer $status The HTTP status code.
     * @throws UnexpectedValueException if the response format is JSON and neither an array nor object are supplied for $data.
     * @return void
     */
    function __construct($data = '', $json = false, $status = 200)
    {
        if ($json) {
            header('Content-type: application/json');

            if (is_array($data) || is_object($data)) {
                $this->data = json_encode($data);
            } elseif (!empty($data)) {
                throw new \UnexpectedValueException;
            }
        }

        if (!isset($data)) {
            $this->data = $data;
        }

        $this->json   = $json;
        $this->status = $status;
    }

    
    /**
     * Sends a header to the client in the response.
     *
     * @param string $name The name of the header.
     * @param string $value The value corresponding to $name.
     * @return self
     */
    public function header($name, $value)
    {
        header($name . ': ' . $value);

        return $this;
    }

    
    /**
     * Sets the body of the response.
     *
     * @param string|array|object $data The data to send to the client.
     * @return self
     */
    public function body($data)
    {
        if ($this->json) {
            $this->data = json_encode($data);
        } else {
            $this->data = $data;
        }

        return $this;
    }

    
    /**
     * Sets the HTTP status code for the response.
     *
     * @param integer $status The HTTP status code of the response.
     * @return self
     */
    public function status($status)
    {
        $this->status = $status;

        return $this;
    }

    
    /**
     * Sends the HTTP status code and exits the script.
     *
     * @return void
     */
    public function send()
    {
        http_response_code($this->status);

        exit($this->data);
    }
}