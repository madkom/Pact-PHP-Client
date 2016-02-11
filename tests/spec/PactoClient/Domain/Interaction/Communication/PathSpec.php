<?php

namespace spec\Madkom\PactoClient\Domain\Interaction\Communication;

use Madkom\PactoClient\Domain\Interaction\Communication\Path;
use Madkom\PactoClient\PactoException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class PathSpec
 * @package spec\Madkom\PactoClient\Domain\Interaction\Communication
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
        $this->shouldHaveType('Madkom\PactoClient\Domain\Interaction\Communication\Path');
    }

    function it_should_return_path()
    {
        $this->jsonSerialize()->shouldReturn($this->path);
    }

    function it_should_throw_exception_if_wrong_path_passed()
    {
        $this->shouldThrow(PactoException::class)->during('__construct', [null]);
        $this->shouldThrow(PactoException::class)->during('__construct', ['']);
        $this->shouldThrow(PactoException::class)->during('__construct', ['bla']);
        $this->shouldThrow(PactoException::class)->during('__construct', ['bla/']);
        $this->shouldThrow(PactoException::class)->during('__construct', ['bl/a']);
        $this->shouldThrow(PactoException::class)->during('__construct', [123]);
        $this->shouldThrow(PactoException::class)->during('__construct', ['/']);
    }

    function it_should_not_throw_for_correct_path()
    {
        $this->shouldNotThrow(PactoException::class)->during('__construct', ['/resource']);
        $this->shouldNotThrow(PactoException::class)->during('__construct', ['/resource/1']);
        $this->shouldNotThrow(PactoException::class)->during('__construct', ['/resource/1/resource']);
        $this->shouldNotThrow(PactoException::class)->during('__construct', ['/resource/1/resource/30']);
        $this->shouldNotThrow(PactoException::class)->during('__construct', ['/resource/1/resource/30/test']);
    }

}
