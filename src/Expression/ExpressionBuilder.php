<?php

namespace Sphinx\Expression;

use Sphinx\Util;

class ExpressionBuilder
{
    /**
     * Searched fields.
     *
     * @var array
     */
    private $fields = [];

    /**
     * Searched keywords.
     *
     * @var array
     */
    private $terms = [];

    /**
     * @var bool
     */
    private $relaxedMode = false;

    /**
     * Index to search for.
     *
     * @var string
     */
    private $index = '*';

    /**
     * @param $args
     * @return $this
     */
    public function search($args = null)
    {
        $this->terms[] = implode(' ', func_get_args());

        return $this;
    }

    /**
     * Set the fields that will be searched.
     * Last argument can be boolean if field/s should be ignored or
     * can be integer for limit searching to specified position in given field/s.
     *
     * @param $args
     * @return $this
     */
    public function in($args)
    {
        $args = func_get_args();

        $lastArg = (func_num_args() > 1) ? end($args) : null;

        $ignore = is_bool($lastArg) ? array_pop($args) : false;
        $maxPosition = is_int($lastArg) ? array_pop($args) : null;

        $fields = count($args) > 1 ?
            new GroupExpression($args, ',') : reset($args);

        $this->fields[count($this->terms) - 1] =
            (string) new FieldExpression($fields, $maxPosition, $ignore);

        return $this;
    }

    /**
     * Index name or names.
     *
     * @param $args
     * @return $this
     */
    public function index($args = null)
    {
        $this->index = Util::arrayFlatten(func_get_args());

        return $this;
    }

    /**
     * @param null $phrase
     * @return PhraseExpression
     */
    public function phrase($phrase = null)
    {
        return new PhraseExpression($phrase);
    }

    /**
     * @param null|string $phrase
     * @param null|integer $proximity
     * @return ProximityExpression
     */
    public function proximity($phrase = null, $proximity = null)
    {
        return new ProximityExpression($phrase, $proximity);
    }

    /**
     * @param null $phrase
     * @param null $quorum
     * @return QuorumExpression
     */
    public function quorum($phrase = null, $quorum = null)
    {
        return new QuorumExpression($phrase, $quorum);
    }

    /**
     * @param $args
     * @return ExactOrderExpression
     */
    public function exact($args = null)
    {
        return new ExactOrderExpression(func_get_args());
    }

    /**
     * @param $args
     * @return CompositeExpression
     */
    public function comp($args = null)
    {
        return new CompositeExpression(func_get_args());
    }

    /**
     * @param null $args
     * @return GroupExpression
     */
    public function group($args = null)
    {
        $args = func_get_args();

        $type = (func_num_args() > 1 and GroupExpression::validType(end($args))) ?
            array_pop($args) : null;

        return new GroupExpression($args, $type);
    }

    /**
     * @param $field
     * @param null $maxPosition
     * @param bool $ignore
     * @return FieldExpression
     */
    public function field($field, $maxPosition = null, $ignore = true)
    {
        return new FieldExpression($field, $maxPosition, $ignore);
    }

    /**
     * @param null $args
     * @return ExcludeExpression
     */
    public function exclude($args = null)
    {
        $args = func_get_args();

        $args = func_num_args() > 1 ?
            new GroupExpression($args, ',') : reset($args);

        return new ExcludeExpression($args);
    }

    /**
     * Both side wildcard.
     *
     * @param null $phrase
     * @return WildcardExpression
     */
    public function wd($phrase = null)
    {
        return new WildcardExpression($phrase);
    }

    /**
     * Left side wildcard.
     *
     * @param null $phrase
     * @return WildcardExpression
     */
    public function lwd($phrase = null)
    {
        return new WildcardExpression($phrase, WildcardExpression::TYPE_LEFT);
    }

    /**
     * Right side wildcard.
     *
     * @param null $phrase
     * @return WildcardExpression
     */
    public function rwd($phrase = null)
    {
        return new WildcardExpression($phrase, WildcardExpression::TYPE_RIGHT);
    }

    /**
     * Avoid query fail if given field name does not exist in the searched index.
     */
    public function enableRelaxedMode()
    {
        $this->relaxedMode = true;

        return $this;
    }

    /**
     * Enable query fail if given field name does not exist in the searched index.
     */
    public function disableRelaxedMode()
    {
        $this->relaxedMode = false;

        return $this;
    }

    /**
     * @param bool $reset Reset expression builder params.
     * @return ExpressionQuery
     */
    public function getQuery($reset = true)
    {
        $expressionQuery = new ExpressionQuery(
            $this->terms, $this->fields, $this->index, $this->relaxedMode
        );

        if($reset) {
            $this->reset();
        }

        return $expressionQuery;
    }

    /**
     * Restore default values.
     */
    private function reset()
    {
        $this->fields = $this->terms = [];
    }
}