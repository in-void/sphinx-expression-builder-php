<?php

namespace Sphinx\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Sphinx\Util;

class UtilTest extends TestCase
{
    /**
     * @covers ::arrayFlatten
     */
    public function testArrayFlatten()
    {
        $this->assertSame(['hello', 'world'], Util::arrayFlatten([0 => ['hello', 'world']]));
    }
}