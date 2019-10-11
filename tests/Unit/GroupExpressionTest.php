<?php

namespace Sphinx\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Sphinx\Expression\GroupExpression;

class GroupExpressionTest extends TestCase
{
    public function testGroupExpression()
    {
        $this->assertEquals('(hello world)', (string) new GroupExpression(['hello', 'world']));
    }

    public function testOrGroupExpression()
    {
        $this->assertEquals('(hello|world)', (string) new GroupExpression(['hello', 'world'], GroupExpression::TYPE_OR));
    }

    public function testAndGroupExpression()
    {
        $this->assertEquals('(hello&world)', (string) new GroupExpression(['hello', 'world'], GroupExpression::TYPE_AND));
    }

    public function testValidType()
    {
        $this->assertTrue(GroupExpression::validType(GroupExpression::TYPE_AND));
        $this->assertTrue(GroupExpression::validType(GroupExpression::TYPE_OR));
        $this->assertFalse(GroupExpression::validType(4));
    }
}