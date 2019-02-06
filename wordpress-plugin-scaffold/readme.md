# wordpress-plugin-scaffold

> A template for WordPress plugin development with some dependencies I find useful.

## Introduction

I wanted to create a template for WordPress plugin development that could quickly get me up and running. So here it is.

In the first version of this project I set out to write utilities that would allow myself (_and others, if anyone ever uses this_) to easily bring a MVC-like
structure to my plugins. Because of time constraints I never fully fleshed out these ideas and it went mostly unfinished. My plan now with the project is to
roll out utilities as I have time to write them, and I've removed the unfinished model and controller layers until I can better envision how these might work
within WordPress.

## Installation

1. `composer install` to fetch PHP dependencies
2. `npm install` to fetch Node dependencies, if you intend to use any
3. Edit `plugin.php` and begin developing your plugin (_don't forget to rename it!_)

## Tools

### Template rendering

[Twig](http://twig.sensiolabs.org/doc/1.x/) v1.31.0 is included for template rendering (_no more mixing HTML and PHP!_). It's currently locked at an earlier version because, when I began this project, it was mainly for use at work where we previously ran PHP 5.3. We've since upgraded and soon I intend to look into upgrading Twig.

### Zip archive

To distribute your plugin, edit `gulpfile.js` with the information specific to your plugin.
Then to generate a zip archive of the files you've specified, run `gulp distribute`. 

### Application registry

I've included a little registry class for sharing objects. Documentation is on my to do list, but it's pretty straightforward; check out `/src/Registry.php` and
read the docblocks if you want to go ahead with it.