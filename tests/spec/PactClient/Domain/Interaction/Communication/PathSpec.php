<?php

namespace spec\Madkom\PactClient\Domain\Interaction\Communication;

use Madkom\PactClient\Domain\Interaction\Communication\Path;
use Madkom\PactClient\PactException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class PathSpec
 * @package spec\Madkom\PactClient\Domain\Interaction\Communication
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 * @mixin Path
 */
class PathSpec extends ObjectBehavior
{

    private $path;

    function let()
    {
        $this->path = '/path/to/some';
        $this->beConstructedWith($this->path);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Madkom\PactClient\Domain\Interaction\Communication\Path');
    }

    function it_should_return_path()
    {
        $this->jsonSerialize()->shouldReturn($this->path);
    }

    function it_should_throw_exception_if_wrong_path_passed()
    {
        $this->shouldThrow(PactException::class)->during('__construct', [null]);
        $this->shouldThrow(PactException::class)->during('__construct', ['']);
        $this->shouldThrow(PactException::class)->during('__construct', ['bla']);
        $this->shouldThrow(PactException::class)->during('__construct', ['bla/']);
        $this->shouldThrow(PactException::class)->during('__construct', ['bl/a']);
        $this->shouldThrow(PactException::class)->during('__construct', [123]);
        $this->shouldThrow(PactException::class)->during('__construct', ['/']);
    }

    function it_should_not_throw_for_correct_path()
    {
        $this->shouldNotThrow(PactException::class)->during('__construct', ['/resource']);
        $this->shouldNotThrow(PactException::class)->during('__construct', ['/resource/1']);
        $this->shouldNotThrow(PactException::class)->during('__construct', ['/resource/1/resource']);
        $this->shouldNotThrow(PactException::class)->during('__construct', ['/resource/1/resource/30']);
        $this->shouldNotThrow(PactException::class)->during('__construct', ['/resource/1/resource/30/test']);
    }

}
