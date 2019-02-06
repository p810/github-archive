# event-emitter

> An event broadcaster for PHP inspired by Node's EventEmitter.

## Installation

```
composer require p810/event-emitter --no-dev
```

Omit the `--no-dev` flag if you wish to run the unit tests in `tests/`.

## Usage

An instance of `p810\EventEmitter\EventEmitter` will maintain an associative
array of event names to queues of callbacks. When an event is triggered it will
execute each callback in the order that they were enqueued.

```php
<?php

require_once './vendor/autoload.php';

$eventEmitter = new p810\EventEmitter\EventEmitter;

for ($i = 1; $i < 5; $i++) {
    $eventEmitter->on('multiply', function (int $number) use ($i) {
        return $number * $i;
    });
}

foreach ($eventEmitter->emit('multiply', 2) as $result) {
    echo $result, PHP_EOL;
}
```

### Tips

#### :bulb: Fetch all values as an array
Since `EventEmitter::emit()` returns a [`Generator`](http://php.net/manual/en/language.generators.overview.php)
it's possible to get an array of the values it yields by calling [`iterator_to_array()`](http://php.net/manual/en/function.iterator-to-array.php)
on the method. Example:

```php
$results = iterator_to_array( $eventEmitter->on('some.event') );
```

#### :bulb: The splat operator is your friend
Using the [splat operator](http://php.net/manual/en/functions.arguments.php#functions.variable-arg-list)
to collect arguments passed to your event handlers is my recommended way of doing it,
since you can pass as few or as many arguments you want into the method. Example:

```php
$eventEmitter->on('some.event', function (...$args): string {
    // $args will always be an array, even if no arguments are provided.
    switch (count($args)) {
        case 0:
            return 'No arguments were passed.';
        break;

        case 1:
            return 'Look ma, an argument!';
        break;

        case 2:
            return 'You get the idea.';
        break;
    }
});

$eventEmitter->emit('some.event');                 # returns: 'No arguments were passed.'
$eventEmitter->emit('some.event', true);           # returns: 'Look ma, an argument!'
$eventEmitter->emit('some.event', 'beep', 'boop'); # returns: 'You get the idea.'
```
