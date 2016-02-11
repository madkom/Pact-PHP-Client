<?php

namespace spec\Madkom\PactoClient\Domain\Interaction\Communication;

use Madkom\PactoClient\Domain\Interaction\Communication\Method;
use Madkom\PactoClient\PactoException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class MethodSpec
 * @package spec\Madkom\PactoClient\Domain\Interaction\Communication
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 * @mixin Method
 */
class MethodSpec extends ObjectBehavior
{

    public function let()
    {
        $this->beConstructedWith('GET');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Madkom\PactoClient\Domain\Interaction\Communication\Method');
    }

    public function it_should_return_type()
    {
        $this->jsonSerialize()->shouldReturn('get');
    }

    public function it_should_throw_exception_if_wrong_method_passed()
    {
        $this->shouldThrow(PactoException::class)->during('__construct', ['']);
        $this->shouldThrow(PactoException::class)->during('__construct', [null]);
        $this->shouldThrow(PactoException::class)->during('__construct', ['NOT']);
        $this->shouldThrow(PactoException::class)->during('__construct', ['aaa']);
        $this->shouldThrow(PactoException::class)->during('__construct', [123]);
    }

    function it_should_not_exception_for_correct_method_types()
    {
        $this->shouldNotThrow(PactoException::class)->during('__construct', ['GET']);
        $this->shouldNotThrow(PactoException::class)->during('__construct', [Method::GET]);
        $this->shouldNotThrow(PactoException::class)->during('__construct', ['POST']);
        $this->shouldNotThrow(PactoException::class)->during('__construct', [Method::POST]);
        $this->shouldNotThrow(PactoException::class)->during('__construct', ['PUT']);
        $this->shouldNotThrow(PactoException::class)->during('__construct', [Method::PUT]);
        $this->shouldNotThrow(PactoException::class)->during('__construct', ['DELETE']);
        $this->shouldNotThrow(PactoException::class)->during('__construct', [Method::DELETE]);
    }

}
