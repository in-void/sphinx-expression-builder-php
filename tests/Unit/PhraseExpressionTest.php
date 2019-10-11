<?php

namespace Sphinx\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Sphinx\Expression\PhraseExpression;

class PhraseExpressionTest extends TestCase
{
    public function testPhraseExpression()
    {
        $this->assertEquals('"hello world"', (string) new PhraseExpression('hello world'));
    }
}