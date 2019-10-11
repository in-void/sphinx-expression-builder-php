<?php

namespace Sphinx\Expression;

class PositionExpression extends Expression
{
    /**
     * Position when engine will looking for words.
     *
     * @var int
     */
    private $position;

    /**
     * @param integer $position
     */
    public function __construct($position)
    {
        $this->position = (int) $position;
    }

    public function __toString()
    {
        return '[' . $this->position . ']';
    }
}