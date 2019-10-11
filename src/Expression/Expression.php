<?php

namespace Sphinx\Expression;

abstract class Expression
{
    /**
     * @var string
     */
    protected $expression;

    /**
     * @param string $expression
     */
    public function __construct($expression)
    {
        $this->expression = $expression;
    }

    public function __toString()
    {
        return (string) $this->expression;
    }
}