<?php

namespace p810\Amethyst\Session;

use p810\Amethyst\Application;

class Session
{
    /**
     * Sets the session handling strategy and calls session_start().
     *
     * A strategy class must implement SessionHandlerInterface.
     *
     * If your strategy utilizes a database it must adhere to the schema defined by Amethyst. In a later version, a SQL file
     * will be included in the Strategy namespace beneath this one.
     *
     * @param string $strategy The name of the class belonging to the namespace p810\Amethyst\Session\Strategy.
     * @see <http://php.net/manual/en/class.sessionhandlerinterface.php>
     * @see <http://php.net/manual/en/function.session-start.php>
     * @return void
     */
    function __construct($strategy)
    {
        $app = Application::getInstance();

        $this->strategy = $app->resolve('Session.Strategy.' . $strategy);

        session_set_save_handler($this->strategy, true);

        session_start();
    }
}