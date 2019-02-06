<?php

namespace p810\ConfigStore;

abstract class Loader {
    function __construct() {
        $this->factory = function ($data) {
            return new ConfigStore($data);
        };
    }

    final public function load($source) {
        $data = $this->get($source);
        $data = $this->parse($data);

        return ($this->factory)($data);
    }

    public function setFactoryMethod(callable $callback): self {
        $this->factory = $callback;

        return $this;
    }

    /**
     * `get()` will fetch the data from the specified source. This will
     * most likely be a file or database object depending on how your app
     * is set up.
     * 
     * `parse()` will then format the data before it's passed into the
     * factory method that returns your config object.
     */
    abstract protected function get($source);
    abstract protected function parse($data);
}