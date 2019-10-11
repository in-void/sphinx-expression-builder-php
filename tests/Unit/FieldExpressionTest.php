<?php

namespace Sphinx\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Sphinx\Expression\FieldExpression;

class FieldExpressionTest extends TestCase
{
    public function testFieldExpression()
    {
        $this->assertEquals('@hello', (string) new FieldExpression('hello'));
    }

    public function testFieldPositionLimit()
    {
        $this->assertEquals('@hello[10]', (string) new FieldExpression('hello', 10));
    }

    public function testIgnoreFieldExpression()
    {
        $this->assertEquals('@!hello', (string) new FieldExpression('hello', null, true));
    }

    public function testSearchAllFieldExpression()
    {
        $this->assertEquals('@*', (string) new FieldExpression(FieldExpression::SEARCH_All));
    }
}