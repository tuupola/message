<?php

namespace spec\Http\Message\Encoding;

use Psr\Http\Message\StreamInterface;
use PhpSpec\Exception\Example\SkippingException;
use PhpSpec\ObjectBehavior;

class GzipEncodeStreamSpec extends ObjectBehavior
{
    use StreamBehavior, ZlibStreamBehavior;

    function let(StreamInterface $stream)
    {
        if (defined('HHVM_VERSION')) {
            throw new SkippingException('Skipping test as zlib is not working on hhvm');
        }

        $this->beConstructedWith($stream);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Http\Message\Encoding\GzipEncodeStream');
    }

    function it_reads()
    {
        $stream = new MemoryStream('This is a test stream');
        $this->beConstructedWith($stream);

        $stream->rewind();
        $this->read(4)->shouldReturn(substr(gzencode('This is a test stream'),0, 4));
    }

    function it_gets_content()
    {
        $stream = new MemoryStream('This is a test stream');
        $this->beConstructedWith($stream);

        $stream->rewind();
        $this->getContents()->shouldReturn(gzencode('This is a test stream'));
    }
}
