<?php

namespace Sphinx\Expression;

class PhraseExpression extends Expression
{
    public function __toString()
    {
        return '"' . $this->expression . '"';
    }
}