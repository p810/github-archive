<?php

namespace p810\Configuration\Schema;

use p810\Configuration\Schema\Value;

abstract class Parser
{
    /**
     * An array of config values after being parsed.
     *
     * @access protected
     * @var array
     */
    protected $parsed;


    /**
     * Takes the contents of a config file and evaluates it.
     *
     * @param array $contents The contents of the config file being evaluated as an array.
     * @return array
     */
    public function evaluate(array $contents) {
        foreach ($contents as $line) {
            $line = trim($line);

            foreach ($this->types as $type => $expression) {
                $result = call_user_func_array([$this, 'match'], [$type, $expression, $line]);

                if ($result instanceof Value) {
                    if (array_key_exists($type, $this->handlers)) {
                        call_user_func_array([ $this, $this->handlers[$type] ], [$result]);
                    }

                    break;
                }
            }
        }

        return $this->parsed;
    }


    /**
     * Attempts to match $line against the supplied expression.
     *
     * If a match was found then the return value will be an instance of p810\Configuration\Schema\Value.
     *
     * @param string $type       The type of line being tested.
     * @param string $expression A regular expression to test against.
     * @param string $line       A line from the config file.
     * @return boolean|object
     */
    public function match($type, $expression, $line) {
        $matched = preg_match($expression, $line, $matches);

        if (!$matched) {
            return false;
        }

        return new Value($type, $matches[1], $matches[2]);
    }
}
