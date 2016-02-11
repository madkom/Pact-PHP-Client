<?php

namespace spec\Madkom\PactoClient\Domain\Interaction;

use Madkom\PactoClient\Domain\Interaction\ProviderState;
use Madkom\PactoClient\PactoException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class ProviderStateSpec
 * @package spec\Madkom\PactoClient\Domain\Interaction
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
    }

    public function it_should_throw_exception_if_empty_value_passed()
    {
        $this->shouldThrow(PactoException::class)->during('__construct', ['']);
    }
}
