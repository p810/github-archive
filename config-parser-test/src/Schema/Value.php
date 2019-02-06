<?php

namespace p810\Configuration\Schema;

class Value
{
    /**
     * Constructs a simple object with metadata pertaining to the value it represents.
     *
     * @param string $type  The type of the config value.
     * @param string $key   The name of the config value.
     * @param mixed  $value The actual value being represented.
     */
    function __construct($type, $key, $value) {
        $this->type  = $type;
        $this->key   = $key;
        $this->value = $value;
    }
}
