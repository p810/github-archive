# Foundation-Template

> A Grunt template for quickly setting up Zurb's Foundation.

## Installation

To fetch Sass and Compass, first install the dependencies declared in `Gemfile`:

```
bundle install
```

(If you don't have [Bundler](https://bundler.io) I recommend installing it, but
you can also manually install the gems with `gem install [name]`).

Then for everything else:

```
npm install
```

## Usage

```
grunt
```

This will compile your Sass files and save the output to the `css/` subdirectory;
a minified file will also be saved there. Leave Grunt running and it will listen
for changes to any of the files in the `sass/` subdirectory, then trigger the
compilation task again.
