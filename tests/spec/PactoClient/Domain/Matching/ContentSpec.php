<?php

namespace spec\Madkom\PactoClient\Domain\Matching;

use Madkom\PactoClient\Domain\Matching\Content;
use Madkom\PactoClient\PactoException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class ContentSpec
 * @package spec\Madkom\PactoClient\Domain\Matching
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 * @mixin Content
 */
class ContentSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('key', 'value');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Madkom\PactoClient\Domain\Matching\Content');
    }

    function it_should_return_values_it_was_constructed_with()
    {
        $this->key()->shouldReturn('key');
        $this->value()->shouldReturn('value');
    }

    function it_should_throw_exception_if_empty_key_or_value()
    {
        $this->shouldThrow(PactoException::class)->during('__construct', ['', '']);
        $this->shouldThrow(PactoException::class)->during('__construct', ['key', '']);
        $this->shouldThrow(PactoException::class)->during('__construct', ['', 'value']);
        $this->shouldThrow(PactoException::class)->during('__construct', ['some', []]);
    }

}
