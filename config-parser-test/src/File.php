<?php

namespace p810\Configuration;

use Exception;
use RuntimeException;
use p810\Configuration\Schema\Parser;

class File
{
    /**
     * An associative array containing parsed configuration values.
     *
     * @access protected
     * @var array
     */
    protected $data;


    /**
     * Retrieves the contents of the config file and parses it.
     *
     * @param string $path   Filepath to the config file that should be parsed.
     * @param object $parser An instance of p810\Configuration\Schema\Parser.
     * @throws RuntimeException if the file could not be found at $path.
     * @throws Exception if calling file() failed.
     * @return void
     */
    function __construct($path, Parser $parser) {
        if (!file_exists($path)) {
            throw new RuntimeException('Could not locate the specified file: ' . $path);

            return;
        }

        $contents = file($path, FILE_SKIP_EMPTY_LINES);

        if ($contents === false) {
            throw new Exception('Failed to read the config file');

            return;
        } else {
            $this->data = $parser->evaluate($contents);
        }
    }


    /**
     * Retrieves one or multiple keys from the config file.
     *
     * @param string|array $key Either a string or array of strings specifying the value(s) to retrieve.
     * @throws Exception if a non-existent key is specified.
     * @return mixed
     */
    public function get($key) {
        if (is_array($key)) {
            $set = [];

            foreach ($key as $single) {
                $set[$single] = $this->get($single);
            }

            return $set;
        }

        if (!array_key_exists($key, $this->data)) {
            throw new Exception('There is no config value by the name of ' . $key);

            return null;
        }

        return $this->data[$key];
    }
}
