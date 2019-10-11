<?php

namespace Sphinx\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Sphinx\Expression\ExpressionQuery;

class ExpressionQueryTest extends TestCase
{
    public function testExpressionQuery()
    {
        $expressionQuery = new ExpressionQuery([], []);
        $this->assertEquals('', (string) $expressionQuery);

        $expressionQuery = new ExpressionQuery(['hello world'], ['@field']);
        $this->assertEquals('@field hello world', (string) $expressionQuery);

        $expressionQuery = new ExpressionQuery(['hello world', 'php python'], ['@field', '@field2']);
        $this->assertEquals('@field hello world @field2 php python', (string) $expressionQuery);

        $expressionQuery = new ExpressionQuery(['hello world'], ['@field', '@field2']);
        $this->assertEquals('@field hello world', (string) $expressionQuery);

        $expressionQuery = new ExpressionQuery(['hello world'], ['@field'], '*', true);
        $this->assertEquals('@@relaxed @field hello world', (string) $expressionQuery);
    }
}