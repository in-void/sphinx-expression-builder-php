<?php

namespace Sphinx\Expression;

/**
 * Using star syntax when searching through indexes.
 */
class WildcardExpression extends Expression
{
    const TYPE_LEFT = 1;

    const TYPE_RIGHT = 2;

    /**
     * @var bool|int
     */
    protected $wildcardType;

    /**
     * @param string $expression
     * @param bool|int $wildcardType
     */
    public function __construct($expression, $wildcardType = false)
    {
        parent::__construct($expression);

        $this->wildcardType = $wildcardType;
    }

    public function __toString()
    {
        $prefix = (!$this->wildcardType or $this->wildcardType == self::TYPE_LEFT) ? '*' : '';
        $suffix = (!$this->wildcardType or $this->wildcardType == self::TYPE_RIGHT) ? '*' : '';

        return $prefix . $this->expression . $suffix;
    }
} 