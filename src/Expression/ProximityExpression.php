<?php

namespace Sphinx\Expression;

/**
 * Proximity distance is specified in words, adjusted for word count, and applies to all words within quotes.
 * For instance, "cat dog mouse"~5 query means that there must be less than 8-word span which contains
 * all 3 words, ie. "CAT aaa bbb ccc DOG eee fff MOUSE" document will not match this query,
 * because this span is exactly 8 words long.
 */
class ProximityExpression extends PhraseExpression
{
    /**
     * Maximum distance between searched words.
     *
     * @var integer
     */
    private $proximity;

    /**
     * @param string $phrase
     * @param integer $proximity
     */
    public function __construct($phrase, $proximity)
    {
        parent::__construct($phrase);
        $this->proximity = (int) $proximity;
    }

    public function __toString()
    {
        return parent::__toString() . '~' . $this->proximity;
    }
}