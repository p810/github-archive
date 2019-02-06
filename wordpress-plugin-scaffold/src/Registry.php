<?php

namespace p810\WPScaffold;

class Registry
{
    /**
     * @access protected
     * @var mixed[]
     */
    protected $objects = [];

    /**
     * Adds an object to the registry.
     *
     * @param string   $key       A unique name for the class to be identified by.
     * @param callable $callback  A callback which returns an instance of the class.
     * @param bool     $singleton Whether only one instance should exist, or if $callback should be invoked when resolving the class.
     * @return self
     */
    public function register($key, $callback, $singleton = false) {
        $this->objects[$key] = [
            'instances' => [],
            'callback'  => $callback
        ];

        $this->resolve($key);

        if ($singleton) {
            $this->objects[$key]['callback'] = null;
        }

        return $this;
    }

    /**
     * Retrieves an object from the registry.
     *
     * If $index is not specified, then it will default to the first index in
     * the $key's `instances` array.
     *
     * @param string $key   The name of the class to retrieve as specified by `Registry::register()`.
     * @param int    $index The position of the requested class's instance in `Registry::$objects`.
     * @throws OutOfBoundsException
     * @return object
     */
    public function one($key, $index = 0) {
        if (!$this->has($key)) throw new \OutOfBoundsException;

        if ($this->objects[$key]['callback'] == null) {
            return $this->objects[$key]['instances'][0];
        } else {
            if (!array_key_exists($index, $this->objects[$key]['instances'])) {
                throw new \OutOfBoundsException;
            }
        }

        return $this->objects[$key]['instances'][$index];
    }

    /**
     * Returns the entire list of instances of a class in the registry.
     *
     * @param string $key The name of the class to retrieve as specified by `Registry::register()`.
     * @throws OutOfBoundsException
     * @return object[]
     */
    public function all($key) {
        if (!$this->has($key)) throw new \OutOfBoundsException;

        return $this->objects[$key]['instances'];
    }

    /**
     * Creates a new instance of a class in the registry and returns it.
     *
     * @param string $key The name of the class to resolve as specified by `Registry::register()`. 
     * @throws Exception
     * @throws OutOfBoundsException
     * @throws UnexpectedValueException
     * @return object
     */
    public function resolve($key) {
        if (!$this->has($key)) throw new \OutOfBoundsException;

        if ($this->objects[$key]['callback'] == null) {
            throw new \Exception($key . ' cannot be resolved more than once.');
        }

        $object = $this->objects[$key]['callback']();

        if (!is_object($object)) {
            throw new \UnexpectedValueException;
        }

        return ($this->objects[$key]['instances'][] = $object);
    }

    /**
     * Returns the number of instances belonging to a $key.
     *
     * @param string $key The name of the class to count as specified by `Registry::register()`.
     * @throws OutOfBoundsException
     * @return int
     */
    public function count($key) {
        if (!$this->has($key)) throw new \OutOfBoundsException;

        return count($this->objects[$key]['instances']);
    }

    /**
     * Returns whether the $key is a valid name in the registry.
     *
     * @param string $key The name of the class to check for, as specified by `Registry::register()`.
     * @return bool
     */
    public function has($key) {
        return array_key_exists($key, $this->objects);
    }
}
