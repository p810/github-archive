<?php

namespace p810\Amethyst;

class Application
{
    /**
     * Stores a reference to an instance of this class.
     *
     * @var object
     * @access public
     */
    public static $instance;
    

    /**
     * An associative array of objects.
     *
     * @var array
     * @access protected
     */
    protected $objects = array();


    /**
     * Root namespace for classes belonging to Amethyst.
     *
     * @var string
     * @access protected
     */
    protected $namespace = 'p810\\Amethyst\\';


    /**
     * Returns a single instance of this class.
     *
     * @return self
     */
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new Application;
        }

        return self::$instance;
    }


    /**
     * Replaces "." characters with "\" and returns a class name.
     *
     * If the class could not be found, then Application::$namespace will be prefixed to it.
     *
     * @param string $class The class being resolved.
     * @return string
     */
    protected function getFullClassName($class)
    {
        if (stripos($class, '.') !== false) {
            $class = str_replace('.', '\\', $class);
        }

        if (!class_exists($class)) {
            return $this->namespace . $class;
        }

        return $class;
    }


    /**
     * Creates a new instance of a class.
     *
     * @param string $class The class to instantiate.
     * @param mixed $arguments A variadic list of arguments.
     * @return object
     */
    protected function create($class, $arguments)
    {
        $reflection = new \ReflectionClass($class);

        return $reflection->newInstanceArgs($arguments);
    }


    /**
     * Creates an object and adds it to the container.
     *
     * @param string $class The class to instantiate.
     * @param mixed $arguments A variadic list of arguments.
     * @return object
     */
    public function resolve($class, ...$arguments)
    {
        $class = $this->getFullClassName($class);

        if (!array_key_exists($class, $this->objects)) {
            $this->objects[$class] = [];
        }

        $object = $this->objects[$class][] = $this->create($class, $arguments);

        return $object;
    }


    /**
     * Attempts to find an object in the container and returns it if one exists. Otherwise, one will be created and returned.
     *
     * @param string $class The class to instantiate.
     * @param mixed $arguments A variadic list of arguments.
     * @return object
     */
    public function single($class, ...$arguments)
    {
        $object = $this->find($class);

        if ($object) {
            return $object;
        } else {
            return $this->resolve($class, ...$arguments);
        }
    }


    /**
     * Searches for an instance of the given class in the container.
     *
     * @param string $class The class to find.
     * @return bool|object
     */
    public function find($class)
    {
        $class = $this->getFullClassName($class);

        if (!array_key_exists($class, $this->objects)) {
            return false;
        }

        return $this->objects[$class];
    }


    /**
     * If multiple instances of a class have been resolved by the container, this method will allow for retrieving
     * an instance at the given index.
     *
     * @param string $class The class to find.
     * @param int $index The index of the specific object that is requested.
     * @throws OutOfBoundsException if the class has not been resolved by the container.
     * @throws OutOfBoundsException if the requested index is a higher value than the total number of instances registered.
     * @return object
     */
    public function get($class, $index = 0)
    {
        $class = $this->getFullClassName($class);

        if (!$this->find($class)) {
            throw new \OutOfBoundsException($class . ' has not been registered to the container');
        } elseif (!is_array($this->objects[$class])) {
            return $this->objects[$class];
        }

        if (count($this->objects[$class] < $index)) {
            throw new \OutOfBoundsException;
        }

        return $this->objects[$class][$index];
    }


    /**
     * A private constructor for this class to prevent direct instantiation.
     *
     * @return void
     */
    private function __construct() {}
}