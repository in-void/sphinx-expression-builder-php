<?php

namespace Sphinx\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Sphinx\Expression\QuorumExpression;

class QuorumExpressionTest extends TestCase
{
    public function testQuorumExpression()
    {
        $this->assertEquals('"hello world"/4', (string) new QuorumExpression('hello world', 4));
    }
}