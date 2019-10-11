<?php

namespace Sphinx\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Sphinx\Expression\CompositeExpression;

class CompositeExpressionTest extends TestCase
{
    public function testGroupExpression()
    {
        $this->assertEquals('hello world', (string) new CompositeExpression(['hello', 'world']));
    }
}