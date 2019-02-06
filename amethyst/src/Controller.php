<?php

namespace p810\Amethyst;

use p810\Amethyst\Application;

abstract class Controller
{
    /**
     * Makes a property which stores an instance of p810\Amethyst\Application available to child classes.
     *
     * @return void
     */
    function __construct()
    {
        $this->app = Application::getInstance();
    }
}