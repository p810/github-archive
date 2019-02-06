<?php

namespace p810\Amethyst\Database;

use p810\MySQL\Connection;
use p810\Amethyst\Application;

class MySQL
{
    /**
     * Creates an instance of p810\MySQL\Connection.
     *
     * @see p810\MySQL\Connection::__construct().
     * @return void
     */
    function __construct($user, $password, $database, $server = null)
    {
        $this->connection = new Connection($user, $password, $database, $server);
    }

    
    /**
     * Delegates calls to methods on instances of this class to the instance of p810\MySQL\Connection created when the
     * object was instantiated.
     *
     * @param string $method The method name.
     * @param mixed $arguments A variadic list of arguments.
     * @return mixed
     */
    function __call($method, $arguments = null)
    {
        return call_user_func_array([$this->connection, $method], $arguments);
    }
}