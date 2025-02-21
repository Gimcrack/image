<?php

use Intervention\Image\Commands\LineCommand;
use PHPUnit\Framework\TestCase;

class LineCommandTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
    }

    public function testGd()
    {
        $resource = imagecreatefromjpeg(__DIR__.'/images/test.jpg');
        $driver = Mockery::mock('\Intervention\Image\Gd\Driver');
        $driver->shouldReceive('getDriverName')->once()->andReturn('Gd');
        $image = Mockery::mock('\Intervention\Image\Image');
        $image->shouldReceive('getDriver')->once()->andReturn($driver);
        $image->shouldReceive('getCore')->once()->andReturn($resource);
        $command = new LineCommand([10, 15, 100, 150]);
        $result = $command->execute($image);
        $this->assertTrue($result);
        $this->assertFalse($command->hasOutput());
    }

    public function testImagick()
    {
        $imagick = Mockery::mock('\Imagick');
        $imagick->shouldReceive('drawimage');
        $driver = Mockery::mock('\Intervention\Image\Imagick\Driver');
        $driver->shouldReceive('getDriverName')->once()->andReturn('Imagick');
        $image = Mockery::mock('\Intervention\Image\Image');
        $image->shouldReceive('getDriver')->once()->andReturn($driver);
        $image->shouldReceive('getCore')->once()->andReturn($imagick);

        $command = new LineCommand([10, 15, 100, 150]);
        $result = $command->execute($image);
        $this->assertTrue($result);
        $this->assertFalse($command->hasOutput());
    }

}
