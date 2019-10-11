<?php

namespace Sphinx\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Sphinx\Expression\ExcludeExpression;

class ExcludeExpressionTest extends TestCase
{
    public function testExcludeExpression()
    {
        $this->assertEquals('!hello', (string) new ExcludeExpression('hello'));
    }
}