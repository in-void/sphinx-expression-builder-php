<?php

namespace Sphinx\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Sphinx\Expression\ExactOrderExpression;

class ExactOrderExpressionTest extends TestCase
{
    public function testExactOrderExpression()
    {
        $this->assertEquals('new << world << order', (string) new ExactOrderExpression(['new', 'world', 'order']));
    }
}