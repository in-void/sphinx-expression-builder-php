<?php

namespace Sphinx\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Sphinx\Expression\PositionExpression;

class PositionExpressionTest extends TestCase
{
    public function testPositionExpression()
    {
        $this->assertEquals('[10]', (string) new PositionExpression('10'));
    }
}