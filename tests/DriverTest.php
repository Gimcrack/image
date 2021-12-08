<?php

use Intervention\Image\Gd\Driver as GdDriver;
use Intervention\Image\Imagick\Driver as ImagickDriver;
use PHPUnit\Framework\TestCase;

class DriverTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
    }

    public function testNewImageGd()
    {
        $driver = new GdDriver(
            Mockery::mock(\Intervention\Image\Gd\Decoder::class),
            Mockery::mock(\Intervention\Image\Gd\Encoder::class)
        );

        $image = $driver->newImage(300, 200, '00ff00');
        $this->assertInstanceOf(\Intervention\Image\Image::class, $image);
        $this->assertInstanceOf(\Intervention\Image\Gd\Driver::class, $image->getDriver());
        $this->assertIsObject($image->getCore());
    }

    public function testNewImageImagick()
    {
        $driver = new ImagickDriver(
            Mockery::mock(\Intervention\Image\Imagick\Decoder::class),
            Mockery::mock(\Intervention\Image\Imagick\Encoder::class)
        );

        $image = $driver->newImage(300, 200, '00ff00');
        $this->assertInstanceOf(\Intervention\Image\Image::class, $image);
        $this->assertInstanceOf(ImagickDriver::class, $image->getDriver());
        $this->assertInstanceOf(\Imagick::class, $image->getCore());
    }

    public function testParseColorGd()
    {
        $driver = new GdDriver(
            Mockery::mock(\Intervention\Image\Gd\Decoder::class),
            Mockery::mock(\Intervention\Image\Gd\Encoder::class)
        );

        $color = $driver->parseColor('00ff00');
        $this->assertInstanceOf(\Intervention\Image\Gd\Color::class, $color);
    }

    public function testParseColorImagick()
    {
        $driver = new ImagickDriver(
            Mockery::mock(\Intervention\Image\Imagick\Decoder::class),
            Mockery::mock(\Intervention\Image\Imagick\Encoder::class)
        );

        $color = $driver->parseColor('00ff00');
        $this->assertInstanceOf(\Intervention\Image\Imagick\Color::class, $color);
    }
}
