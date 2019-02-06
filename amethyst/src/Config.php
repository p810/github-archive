<?php

namespace p810\Amethyst;

use p810\Dot\Parser as Dot;

class Config
{
    /**
     * Reads the contents of a JSON config file and stores the result as an associative array.
     *
     * @param string $path The path to the project's config file.
     * @throws Exception if $path could not be read by file_get_contents().
     * @throws Exception if there was an issue decoding the JSON.
     * @return void
     */
    function __construct($path)
    {
        $data = @file_get_contents($path);

        if ($data === false) {
            throw new \Exception('Failed to read the contents of ' . $path);
        }

        $data = json_decode($data, true);

        if (is_null($data)) {
            throw new \Exception('Failed to decode JSON. Message: ' . json_last_error_msg());
        }

        $this->data = $data;
    }


    /**
     * Returns a value if the index exists within the config file or false if not.
     *
     * @param string $index The index to locate. (Use dot notation to specify nested indexes.)
     * @return boolean|mixed
     */
    public function find($index)
    {
        if (stripos($index, '.') !== false) {
            try {
                $value = Dot::find($index, $this->data);
            } catch (\OutOfBoundsException $e) {
                return false;
            }
        } else {
            if (array_key_exists($index, $this->data) === false) {
                return false;
            }

            $value = $this->data[$index];
        }

        return $value;
    }

    
    /**
     * Provides access to options stored in the configuration file.
     *
     * Dot notation must be used to traverse multiple levels of a dictionary in the config file. Example:
     * db.name -> { "db": {"name": "database_name"} }
     *
     * An array may be passed into this method instead of a string to access multiple values in a single call.
     *
     * @param string|array $key The name or names of a key or keys to read.
     * @param boolean $associative If $key is an array, this boolean specifies whether to return an associative or numeric array.
     * @return mixed
     */
    public function get($key, $associative = false)
    {
        if (is_array($key)) {
            $result = [];

            foreach($key as $item) {
                if ($associative) {
                    $result[$item] = $this->find($item);
                } else {
                    $result[] = $this->find($item);
                }
            }

            return $result;
        }

        if (stripos($key, '.') !== false) {
            $value = $this->find($key);
        } else {
            $value = $this->data[$key];
        }

        return $value;
    }
}