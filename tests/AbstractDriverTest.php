<?php

use PHPUnit\Framework\TestCase;

class AbstractDriverTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
    }

    public function testExecuteCommand()
    {
        $this->expectException(\Intervention\Image\Exception\NotSupportedException::class);
        $image = Mockery::mock('Intervention\Image\Image');
        $driver = $this->getMockForAbstractClass('\Intervention\Image\AbstractDriver');
        $command = $driver->executeCommand($image, 'xxxxxxxxxxxxxxxxxxxxxxx', []);
    }
}
