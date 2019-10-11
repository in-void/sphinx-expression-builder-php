<?php

namespace Sphinx\Expression;

class ExactOrderExpression extends Expression
{
    /**
     * @var Expression[]
     */
    private $expressions;

    /**
     * @param array $expressions
     */
    public function __construct(array $expressions)
    {
        $this->expressions = $expressions;
    }

    public function __toString()
    {
        return implode(' << ', $this->expressions);
    }
}