<?php
/*
Plugin Name: wp-dbvm
Plugin URI: https://p810.me/wp/dbvm
Description: A tool for implementing version management for your plugin's database schema.
Version: 0.1.0
Author: Payton Bice
Author URI: https://p810.me
*/

namespace p810\dbvm;

/**
 * @param int $currentVersion
 * @param int $latestVersion
 * @param callable[] $callbacks
 * @return callable[]
 */
function compare($currentVersion, $latestVersion, $callbacks) {
    $_callbacks = [];

    if ($currentVersion >= $latestVersion) {
        return $_callbacks;
    }

    $start = $currentVersion + 1;
    for ($i = $start; $i <= $latestVersion; $i++) {
        if (! array_key_exists($i, $callbacks)) {
            throw new \OutOfBoundsException('No handler was supplied for version ' . $i);
        }

        $_callbacks[$i] = $callbacks[$i];
    }

    return $_callbacks;
}

/**
 * @param callable[] $callbacks
 * @param callable $onSuccess
 * @param callable $failureHandler
 * @return mixed
 */
function apply($callbacks, $onFailure = null, $onSuccess = null) {
    foreach ($callbacks as $version => $callback) {
        $success = $callback();

        if (! $success) {
            $val = $version - 1;

            if (is_callable($onFailure)) {
                $val = $onFailure($val);
            }

            return $val;
        }
    }

    return is_callable($onSuccess)
        ? $onSuccess($version)
        : $version;
}
