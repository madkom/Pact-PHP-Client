<?php

namespace spec\Madkom\PactClient\Domain\Interaction;

use Madkom\PactClient\Domain\Interaction\ProviderState;
use Madkom\PactClient\PactException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class ProviderStateSpec
 * @package spec\Madkom\PactClient\Domain\Interaction
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 * @mixin ProviderState
 */
class ProviderStateSpec extends ObjectBehavior
{
    /** @var  string */
    private $value;

    public function let()
    {
        $this->value = 'A request for foo';
        $this->beConstructedWith($this->value);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(\JsonSerializable::class);
    }

    public function it_should_return_value()
    {
        $this->jsonSerialize()->shouldReturn($this->value);
        $this->isEmpty()->shouldReturn(false);
    }

    public function it_should_throw_exception_if_empty_value_passed()
    {
        $this->shouldNotThrow(PactException::class)->during('__construct', ['']);

        $this->isEmpty()->shouldReturn(true);
    }
}
