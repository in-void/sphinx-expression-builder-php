<?php

namespace Sphinx\Expression;

/**
 * Quorum matching operator introduces a kind of fuzzy matching.
 * It will only match those documents that pass a given threshold of given words.
 * Example: ("the world is a wonderful place"/3) will match all documents that have at least 3 of the 6 specified words.
 */
class QuorumExpression extends PhraseExpression
{
    /**
     * @var int
     */
    private $quorum;

    /**
     * @param string $phrase
     * @param integer $quorum
     */
    public function __construct($phrase, $quorum)
    {
        parent::__construct($phrase);
        $this->quorum = (int) $quorum;
    }

    public function __toString()
    {
        return parent::__toString() . '/' . $this->quorum;
    }
}