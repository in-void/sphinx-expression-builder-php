<?php

namespace Sphinx\Expression;

class FieldExpression extends Expression
{
    const SEARCH_All = '*';

    /**
     * Array of fields to searching.
     *
     * @var array
     */
    private $field;

    /**
     * Field position limit.
     *
     * @var null
     */
    private $maxPosition;

    /**
     * Ignore searching in fields.
     *
     * @var bool
     */
    private $ignore;

    /**
     * @param string $field
     * @param null $maxPosition
     * @param bool $ignore
     */
    public function __construct($field, $maxPosition = null, $ignore = false)
    {
        $this->field = $field;
        $this->maxPosition = $maxPosition;
        $this->ignore = $ignore;
    }

    public function __toString()
    {
        $prefix = $this->ignore ? '@!' : '@';
        $suffix = $this->maxPosition ? '[' . $this->maxPosition .']' : '';

        return $prefix . $this->field . $suffix;
    }
}