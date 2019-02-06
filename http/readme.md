# HTTP

> Utility classes for HTTP requests and responses.

## Installation

```
composer require p810/http
```

## Usage

The `Request` class may be used to retrieve information pertaining to the request served by the script, including:

* Query parameters
* Headers
* The client's IP address

`Response` is a class which is used to create a HTTP response. Through it, one may set headers, the status code, and the response body (optionally in JSON).

### Example

```php
<?php

use p810\HTTP\Request;
use p810\HTTP\Response;

/**
 * In this example, we will use the value of a query parameter to greet the user.
 */

// Get the 'name' query parameter

$request = new Request;

$name = $request->getQueryParameter('name');

// Prepare a JSON response

if (is_null($name)) {
    $response = new Response(array('error' => 'You must supply a name'), true, 400);
} else {
    $response = new Response(array('greeting' => sprintf('Hello %s!', $name)), true);
}

$response->send();
```
