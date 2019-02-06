<?php

namespace p810\TableView;

class Table
{
    /**
     * @var p810\TableView\Registry
     * @access protected
     */
    protected $columns;


    /**
     * @var p810\TableView\Registry
     * @access protected
     */
    protected $rows;


    /**
     * @var string
     * @access protected
     */
    protected $output;


    /**
     * @return void
     */
    function __construct() {
        $this->rows    = new Registry;
        $this->columns = new Registry;
    }


    /**
     * Renders a formatted string based on the Translator used.
     *
     * @param p810\TableView\Translators\Translator $translator
     * @return self
     */
    public function render(Translators\Translator $translator): self {
        $this->output = $translator->format($this);

        return $this;
    }


    /**
     * @throws p810\TableView\Exceptions\TableNotRenderedException if the data has not been formatted.
     * @return string
     */
    function __toString(): string {
        if (is_null($this->output)) {
            throw new Exceptions\TableNotRenderedException;
        }

        return $this->output;
    }
}
