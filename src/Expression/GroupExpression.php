<?php

namespace Sphinx\Expression;

class GroupExpression extends Expression
{
    /**
     * Join expressions with `or` char.
     */
    const TYPE_OR = '|';

    /**
     * Join expressions with `and` char.
     */
    const TYPE_AND = '&';

    /**
     * @var array
     */
    private $expressions;

    /**
     * @var null
     */
    private $type;

    /**
     * @param array $expressions
     * @param null $type
     */
    public function __construct(array $expressions, $type = null)
    {
        $this->expressions = $expressions;
        $this->type = $type;
    }

    public function __toString()
    {
        $glue = $this->type ? $this->type : ' ';

        $groupString = '(' . implode($glue, $this->expressions) . ')';

        return $groupString;
    }

    /**
     * Check if `type` is valid glue character.
     *
     * @param $type
     * @return bool
     */
    public static function validType($type)
    {
        return in_array($type, [
            self::TYPE_AND,
            self::TYPE_OR
        ]);
    }
}