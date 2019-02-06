<?php

namespace p810\Configuration\Schema;

use p810\Configuration\Schema\Value;

class DefaultParser
extends Parser
{
    /**
     * A mapping of data types to expressions which may match them.
     *
     * The ordering is important as "string" may match any of the above.
     *
     * @access protected
     * @var array
     */
    protected $types = [
        'comment' => '/^(#)\s?(.*)?/i',
        'number'  => '/([A-Za-z0-9_]+)\s?=\s?([0-9eE.-]+)/i',
        'boolean' => '/([A-Za-z0-9_]+)\s?=\s?(on+?|off+?|true+?|false+?|yes+?|no+?)$/i',
        'string'  => '/([A-Za-z0-9_]+)\s?=\s?([A-Za-z0-9_\/.]+)/i'
    ];


    /**
     * A mapping of data types to methods designated to handle them.
     *
     * @access protected
     * @var array
     */
    protected $handlers = [
        'number'  => 'handleNumber',
        'boolean' => 'handleBoolean',
        'string'  => 'handleString'
    ];


    /**
     * Handles a number.
     *
     * @param object $value An instance of p810\Configuration\Schema\Value.
     * @return void
     */
    public function handleNumber(Value $value) {
        $hasNotation = stripos($value->value, 'e');
        $hasPeriod   = stripos($value->value, '.');

        if ($hasPeriod !== false || $hasNotation !== false) {
            $this->parsed[$value->key] = (float) $value->value;
        } else {
            $this->parsed[$value->key] = (int) $value->value;
        }
    }


    /**
     * Handles a boolean.
     *
     * @param object $value An instance of p810\Configuration\Schema\Value.
     * @return void
     */
    public function handleBoolean(Value $value) {
        switch ($value->value) {
            case 'on':
            case 'yes':
            case 'true':
                $this->parsed[$value->key] = true;
            break;

            case 'no':
            case 'off':
            case 'false':
                $this->parsed[$value->key] = false;
            break;
        }
    }


    /**
     * Handles a string.
     *
     * @param object $value An instance of p810\Configuration\Schema\Value.
     * @return void
     */
    public function handleString(Value $value) {
        $this->parsed[$value->key] = $value->value;
    }
}
