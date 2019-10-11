<?php

namespace Sphinx\Expression;

class ExcludeExpression extends Expression
{
    public function __toString()
    {
        return '!' . $this->expression;
    }
}