<?php

require_once dirname(__FILE__) . '/vendor/autoload.php';

use p810\Configuration\Factory;
use p810\Configuration\Schema\DefaultParser as Parser;

/**
 * The Factory class is used to create instances of File.
 *
 * File objects are accessors for config options in the file they represent.
 *
 * An instance of Factory requires a subclass of p810\Configuration\Schema\Parser,
 * which defines how the lines in the config file will be interpreted, and arranges
 * the data in File.
 */

$factory = new Factory(new Parser);


// A new instance of p810\Configuration\File may be obtained by calling Factory::load().

try {
    $file = $factory->load(dirname(__FILE__) . '/example.ini');
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}


/**
 * The File class exposes one method: File::get().
 *
 * This method takes either a single string or a list of strings and retrieves
 * the values corresponding to those keys in the config file.
 *
 * A non-existent key will throw an Exception. If this Exception is caught then
 * the returned value will be `null`.
 */

try {
    echo $file->get('does_not_exist');
} catch (Exception $e) {
    echo 'The specified key does not exist!' . PHP_EOL;
}

echo $file->get('user') . PHP_EOL;

var_dump($file->get(['host', 'server_load_alarm']));
