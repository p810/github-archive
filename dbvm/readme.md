# dbvm
> A tool for implementing version management for your plugin's database schema.

This was created to be a WordPress plugin but hypothetically it could be used in any project.
I had the idea when I realized I needed a solution to programmatically update a table's schema
and values at deploy time.

The API is simple and straightforward. It's intentionally unopinionated which lends you flexibility
in solving problems such as, "*How should I store and update my project's version number?*"

## Usage
To install the project you may either download the latest tagged release here on GitHub, clone the
repository and run `composer install`, or run `composer require p810/dbvm`.

### API
All functions listed belong in the `p810\dbvm` namespace.

#### `compare(int $currentVersion, int $latestVersion, callable[] $callbacks): callable[]`
`compare()` will take the number of the version your project is currently *at*, the latest version
number, and a map of version numbers to callbacks.

The returned value is a new map of version numbers to callbacks that should be applied.

`OutOfBoundsException` is raised in the event that `$callbacks` does not contain a version number
that should be applied.

**Important: Each of these callbacks should return a boolean indicating if the action succeeded or failed.**

For example if you're on version 2 and the latest version is 5 then the resulting array would
be:

```php
[
    3 => function () { /* ... */ },
    4 => function () { /* ... */ },
    5 => function () { /* ... */ }
]
```

#### `apply(callable[] $callbacks, ?callable $onFailure, ?callable $onSuccess): mixed`
`apply()` walks the map returned by `compare()` and applies each patch.

If a callback returns `false` then the handler specified for failures is invoked and
iteration is stopped. The handler receives the latest successful version number applied.

If all callbacks are successful then the handler specified for success is invoked and it
receives the new current version number as an argument.

**Note: Either handler is optional.**
