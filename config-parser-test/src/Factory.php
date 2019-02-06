<?php

namespace p810\Configuration;

use p810\Configuration\File;
use p810\Configuration\Schema\Parser;

class Factory
{
    /**
     * An instance of p810\Configuration\Schema\Parser.
     *
     * @access protected
     * @var object
     */
    protected $parser;


    /**
     * Injects an instance of p810\Configuration\Schema\Parser.
     *
     * @param object $parser An instance of p810\Configuration\Schema\Parser.
     * @return void
     */
    function __construct(Parser $parser) {
        $this->parser = $parser;
    }


    /**
     * Creates an instance of p810\Configuration\File for the specified config file.
     *
     * @param string $path Filepath to the config file that should be parsed.
     * @return object
     */
    public function load($path) {
        return new File($path, $this->parser);
    }
}
