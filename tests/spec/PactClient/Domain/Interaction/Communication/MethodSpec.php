<?php

namespace spec\Madkom\PactClient\Domain\Interaction\Communication;

use Madkom\PactClient\Domain\Interaction\Communication\Method;
use Madkom\PactClient\PactException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class MethodSpec
 * @package spec\Madkom\PactClient\Domain\Interaction\Communication
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
        $this->shouldHaveType('Madkom\PactClient\Domain\Interaction\Communication\Method');
    }

    public function it_should_return_type()
    {
        $this->jsonSerialize()->shouldReturn('get');
    }

    public function it_should_throw_exception_if_wrong_method_passed()
    {
        $this->shouldThrow(PactException::class)->during('__construct', ['']);
        $this->shouldThrow(PactException::class)->during('__construct', [null]);
        $this->shouldThrow(PactException::class)->during('__construct', ['NOT']);
        $this->shouldThrow(PactException::class)->during('__construct', ['aaa']);
        $this->shouldThrow(PactException::class)->during('__construct', [123]);
    }

    function it_should_not_exception_for_correct_method_types()
    {
        $this->shouldNotThrow(PactException::class)->during('__construct', ['GET']);
        $this->shouldNotThrow(PactException::class)->during('__construct', [Method::GET]);
        $this->shouldNotThrow(PactException::class)->during('__construct', ['POST']);
        $this->shouldNotThrow(PactException::class)->during('__construct', [Method::POST]);
        $this->shouldNotThrow(PactException::class)->during('__construct', ['PUT']);
        $this->shouldNotThrow(PactException::class)->during('__construct', [Method::PUT]);
        $this->shouldNotThrow(PactException::class)->during('__construct', ['DELETE']);
        $this->shouldNotThrow(PactException::class)->during('__construct', [Method::DELETE]);
    }

}
