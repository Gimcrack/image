<?php
use Intervention\Image\Commands\StreamCommand;
use PHPUnit\Framework\TestCase;

class StreamCommandTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
    }

    public function testStreamCreationAndContent()
    {
        $encodedContent = 'sample-content';
        $image = Mockery::mock('Intervention\Image\Image');

        $image->shouldReceive('encode')
            ->with('jpg', 87)
            ->once()
            ->andReturnSelf();

        $image->shouldReceive('getEncoded')
            ->once()
            ->andReturn($encodedContent);

        $command = new StreamCommand(['jpg', 87]);
        $result = $command->execute($image);

        $this->assertTrue($result);
        $this->assertTrue($command->hasOutput());

        $output = $command->getOutput();
        $this->assertInstanceOf('Psr\Http\Message\StreamInterface', $output);
        $this->assertEquals($encodedContent, (string)$output);
    }
}
