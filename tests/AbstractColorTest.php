<?php

use PHPUnit\Framework\TestCase;

class AbstractColorTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
    }

    public function testFormatUnknown()
    {
        $this->expectException(\Intervention\Image\Exception\NotSupportedException::class);
        $color = $this->getMockForAbstractClass('\Intervention\Image\AbstractColor');
        $color->format('xxxxxxxxxxxxxxxxxxxxxxx');
    }
}
