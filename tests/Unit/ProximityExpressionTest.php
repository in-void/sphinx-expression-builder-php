<?php

namespace Sphinx\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Sphinx\Expression\ProximityExpression;

class ProximityExpressionTest extends TestCase
{
    public function testProximityExpression()
    {
        $this->assertEquals('"hello world"~4', (string) new ProximityExpression('hello world', 4));
    }
}