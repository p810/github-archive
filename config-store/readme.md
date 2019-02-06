# config-store
> A lightweight accessor for your config data.

## Installation
This package is available via Packagist.

```
composer require p810/config-store
```

## Usage
Depending on how your data is stored, you will need to instantiate the right loader.
Out of the box I've included support for INI and JSON. If you have another source you
need to support, read the section below, **Extending**.

Dot notation is used to traverse multidimensional data.

If the loader fails to fetch or parse the data, it should raise a `LoadException`.

**example.ini**
```ini
[example-section]
foo = "Hello world!"
```

**test.php**
```php
$loader = new p810\ConfigStore\IniLoader;
$config = $loader->load(__DIR__ . '/example.ini');

if ($config->get('example-section.foo')) {
    // ...
}
```

### Extending
Custom loader classes must inherit from `p810\ConfigStore\Loader` and implement the
`get()` and `parse()` methods.

By default the loader will return a new instance of `p810\ConfigStore\ConfigStore`.
This can be overridden by calling `Loader::setFactoryMethod()` in your implementation.

```php
$loader->setFactoryMethod(function ($data) {
    return new your\custom\DataAccessor($data);
});
```
