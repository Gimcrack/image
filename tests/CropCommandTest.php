<?php

use Intervention\Image\Gd\Commands\CropCommand as CropGd;
use Intervention\Image\Imagick\Commands\CropCommand as CropImagick;
use PHPUnit\Framework\TestCase;

class CropCommandTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
    }

    public function testGd()
    {
        $resource = imagecreatefromjpeg(__DIR__.'/images/test.jpg');
        $image = Mockery::mock('Intervention\Image\Image');
        $image->shouldReceive('getCore')->once()->andReturn($resource);
        $image->shouldReceive('setCore')->once();
        $command = new CropGd([100, 150, 10, 20]);
        $result = $command->execute($image);
        $this->assertTrue($result);
    }

    public function testImagick()
    {
        $imagick = Mockery::mock('Imagick');
        $imagick->shouldReceive('cropimage')->with(100, 150, 10, 20)->andReturn(true);
        $imagick->shouldReceive('setimagepage')->with(0, 0, 0, 0)->once()->andReturn(true);
        $image = Mockery::mock('Intervention\Image\Image');
        $image->shouldReceive('getCore')->times(2)->andReturn($imagick);
        $command = new CropImagick([100, 150, 10, 20]);
        $result = $command->execute($image);
        $this->assertTrue($result);
    }
}
