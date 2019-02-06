<?php

namespace p810\TableView;

class Registry
{
    /**
     * @var mixed[]
     * @access protected
     */
    protected $data = [];


    /**
     * @var int
     * @access protected
     */
    protected $count = -1;


    /**
     * Adds a value to the registry.
     *
     * @param mixed|mixed[] $value
     * @param ?string|int $key
     */
    public function add($value, $key = null): self {
        if (is_array($value)) {
            foreach ($value as $val) {
                $this->add($val);
            }
        }

        if (is_null($key)) {
            $key = $this->count + 1;
        }

        $this->data[$key] = $value;
        ++$this->count;

        return $this;
    }


    /**
     * Removes the specified index from Registry::$data.
     *
     * @param int|string $key
     * @return self
     */
    public function remove($key): self {
        if (!isset($this->data[$key])) {
            throw new \OutOfBoundsException;
        }

        unset($this->data[$key]);
        --$this->count;

        return $this;
    }


    /**
     * Returns the data contained in Registry::$data.
     *
     * @return mixed[]
     */
    public function getData(): array {
        return $this->data;
    }
}
