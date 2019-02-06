<?php

namespace p810\ConfigStore;

use function p810\Dot\find as find;

class ConfigStore {
    function __construct(array $data) {
        $this->data = $data;
    }

    public function get(string $path) {
        return find($path, $this->data);
    }
}