# Notification

> An implementation of the observer pattern.

## Installation

```
composer require p810/notification
```

You may also refer to the release tags on the GitHub repository for archives.

## Why?

After looking into building Wordpress themes and finding the hooks API, I educated myself on event handling and wanted to write a reusable component that I could integrate with my projects down the road. The observer pattern made sense to me for implementation, because it's well documented and something I've understood for a long time at a higher level, but now have a stronger technical grasp on.

## Usage

Extend `p810\Notification\Observer` and attach any Callable as a subscriber (`Observer::register()`). When a notification is broadcasted (`Observer::notify()`), the first argument will always be an instance of the `Observer`. Note that since warnings are suppressed when subscribers are called, one does not have to conform to a specific argument signature.

Results are yielded and can be collected as an array by calling `iterator_to_array()`. To stop calling subscribers, `Observer::stop()` may be called from within the one currently executing.

### Example

The following is an example where an `Observer` sends JSON notifications to each of its subscribers. We use a fake HTTP service to simulate making a POST request with the JSON encoded data sent by the notification. If the request fails, then propagation is stopped, and no more subscribers are called.

```php
<?php

/**
 * Create an observer and an instance of it.
 */
use p810\Notification\Observer;

class EventManager extends Observer {}

$observer = new EventManager;


/**
 * Register a couple callbacks to the observer.
 *
 * The first relies on a fake HTTP service to simulate a POST request. On failure, event propagation is stopped.
 * This way the second callback is never reached.
 */
$observer->register(function(EventManager $event, $json) use ($mockHttpService) {
    $response = $mockHttpService
      ->post('http://example.com')
      ->header('Content-type', 'application/json')
      ->body($json)
    ;

    if ($response->status !== 200) {
        $event->stop();

        return false;
    }

    return $response->body;
});

$observer->register(function() {
    return 'This will never be reached if the first one fails!'; 
});


/**
 * Now we broadcast data to its subscribers.
 *
 * In the first example we use `iterator_to_array()` to collect the results as an array. Only the first callback is called.
 *
 * In the second example, we iterate over results using `foreach`, and with a "correct" API key so that event propagation isn't stopped.
 */

// array ( 0 => false )
$response = iterator_to_array(
    $observer->notify(array(
        'api-key' => 'InvalidAPIKey123',
        'data'    => 'We purposefully set a wrong key to stop propagation.'
    ))
);

$valid_data = array(
    'api_key' => 'abc123',
    'data'    => 'Lorem ipsum dolor sit amet...'
);

foreach ($observer->notify($valid_data) as $response) {
    print $response;
}
```

## Changelog

### v1.1

* Updates docblock comment for `Observer::register()`
* Removes `Observer::beforeNotification()` and `Observer::handleResults()` ability; this should be up to the child class and is not essential to the `Observer`
* Updates example in `readme.md` with comments