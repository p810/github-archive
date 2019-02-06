<?php

namespace p810\ConfigStore;

class IniLoader extends Loader {
    protected function get($file) {
        $data = file_get_contents($file);

        if ($data === false) {
            throw new LoadException("Failed to get data from $file");
        }

        return $data;
    }

    protected function parse($data) {
        $data = parse_ini_string($data, true);

        if ($data === false) {
            throw new LoadException('parse_ini_string() failed');
        }

        return $data;
    }
}