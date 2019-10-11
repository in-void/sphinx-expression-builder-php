<?php

namespace Sphinx\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Sphinx\Expression\WildcardExpression;

class WildcardExpressionTest extends TestCase
{
    public function testWildcardExpression()
    {
        $this->assertEquals('*hello*', (string) new WildcardExpression('hello'));
        $this->assertEquals('*hello', (string) new WildcardExpression('hello', WildcardExpression::TYPE_LEFT));
        $this->assertEquals('hello*', (string) new WildcardExpression('hello', WildcardExpression::TYPE_RIGHT));
    }
}