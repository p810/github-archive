# config-parser-test

> A proof of concept package for parsing configuration files

This is my submission for a code test where the objective was to write PHP code that can parse a configuration file. The rules were:

* Do not use existing configuration parsing libraries/functions
* The code should be able to retrieve the values of config parameters by their respective keys
* Booleans (and boolean-esque values) must return PHP's boolean data type
* Numeric values must return either an `integer` or `float`

## Installation

Clone the repository and run `composer dump-autoload` to generate an autoloader.

## Usage

Refer to `example.php` for a detailed explanation of how the package can be used.
