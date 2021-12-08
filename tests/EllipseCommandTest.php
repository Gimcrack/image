<?php

use Intervention\Image\Commands\EllipseCommand;
use PHPUnit\Framework\TestCase;

class EllipseCommandTest extends TestCase
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
        $command = new EllipseCommand([250, 150, 10, 20]);
        $result = $command->execute($image);
        $this->assertTrue($result);
        $this->assertFalse($command->hasOutput());
    }

    public function testImagick()
    {
        $imagick = Mockery::mock(\Imagick::class);
        $imagick->shouldReceive('drawimage')->andReturn(true);
        $driver = Mockery::mock(\Intervention\Image\Imagick\Driver::class);
        $driver->shouldReceive('getDriverName')->once()->andReturn('Imagick');
        $image = Mockery::mock(\Intervention\Image\Image::class);
        $image->shouldReceive('getDriver')->once()->andReturn($driver);
        $image->shouldReceive('getCore')->once()->andReturn($imagick);

        $command = new EllipseCommand([250, 150, 10, 20]);
        $result = $command->execute($image);
        $this->assertTrue($result);
        $this->assertFalse($command->hasOutput());
    }

}
