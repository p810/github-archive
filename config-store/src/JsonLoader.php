<?php

namespace p810\ConfigStore;

class JsonLoader extends Loader {
    public function get($file) {
        $data = file_get_contents($file);

        if ($data === false) {
            throw new LoadException("Failed to open $file");
        }

        return $data;
    }

    public function parse($data) {
        $data = json_decode($data, true);

        if ($data === null) {
            throw new LoadException(json_last_error_msg());
        }

        return $data;
    }
}