<?php

namespace Sphinx\Expression;

class ExpressionQuery
{
    /**
     * @var array
     */
    private $terms;

    /**
     * @var array
     */
    private $fields;

    /**
     * @var string Compiled expression string.
     */
    private $expression;

    /**
     * @var boolean Avoid errors if field doesn't exists.
     */
    private $relaxedMode;

    /**
     * @var string Searched index.
     */
    private $index;

    /**
     * @param array $terms
     * @param array $fields
     * @param string $index
     * @param bool $relaxedMode
     */
    public function __construct(array $terms, array $fields, $index = '*', $relaxedMode = false)
    {
        $this->terms = $terms;
        $this->fields = $fields;
        $this->index = $index;
        $this->relaxedMode = $relaxedMode;
    }

    /**
     * @return string
     */
    public function getExpressionString()
    {
        if(!$this->expression) {
            $this->compile();
        }

        return $this->expression;
    }

    /**
     * @return string
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * @return mixed
     */
    public function getTerms()
    {
        return $this->terms;
    }

    /**
     * @param array $terms
     */
    public function setTerms(array $terms)
    {
        $this->terms = $terms;
    }

    /**
     * Build expression string.
     */
    private function compile()
    {
        $expression = $fieldsWithTerms = '';

        foreach($this->terms as $key => $term) {
            if(isset($this->fields[$key])) {
                $fieldsWithTerms .= $this->fields[$key] . ' ';
            }

            $fieldsWithTerms .= $term . ' ';
        }

        if($fieldsWithTerms) {
            $expression = $this->relaxedMode ? '@@relaxed ' : '';
            $expression .= trim($fieldsWithTerms);
        }

        $this->expression = $expression;
    }

    public function __toString()
    {
        return $this->getExpressionString();
    }
}