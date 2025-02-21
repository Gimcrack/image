<?php

use Intervention\Image\Gd\Commands\HeightenCommand as HeightenGd;
use Intervention\Image\Imagick\Commands\HeightenCommand as HeightenImagick;
use PHPUnit\Framework\TestCase;

class HeightenCommandTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
    }

    public function testGd()
    {
        $callback = function ($constraint) { $constraint->aspectRatio(); };
        $resource = imagecreatefromjpeg(__DIR__.'/images/test.jpg');
        $image = Mockery::mock('Intervention\Image\Image');
        $size = Mockery::mock('Intervention\Image\Size', [800, 600]);
        $size->shouldReceive('resize')->once()->andReturn($size);
        $size->shouldReceive('getWidth')->once()->andReturn(800);
        $size->shouldReceive('getHeight')->once()->andReturn(600);
        $image->shouldReceive('getWidth')->once()->andReturn(800);
        $image->shouldReceive('getHeight')->once()->andReturn(600);
        $image->shouldReceive('getSize')->once()->andReturn($size);
        $image->shouldReceive('getCore')->once()->andReturn($resource);
        $image->shouldReceive('setCore')->once();
        $command = new HeightenGd([200]);
        $result = $command->execute($image);
        $this->assertTrue($result);
    }

    public function testImagick()
    {
        $callback = function ($constraint) { $constraint->upsize(); };
        $imagick = Mockery::mock('Imagick');
        $imagick->shouldReceive('scaleimage')->with(300, 200)->once()->andReturn(true);
        $size = Mockery::mock('Intervention\Image\Size', [800, 600]);
        $size->shouldReceive('resize')->once()->andReturn($size);
        $size->shouldReceive('getWidth')->once()->andReturn(300);
        $size->shouldReceive('getHeight')->once()->andReturn(200);
        $image = Mockery::mock('Intervention\Image\Image');
        $image->shouldReceive('getCore')->once()->andReturn($imagick);
        $image->shouldReceive('getSize')->once()->andReturn($size);
        $command = new HeightenImagick([200]);
        $result = $command->execute($image);
        $this->assertTrue($result);
    }
}
