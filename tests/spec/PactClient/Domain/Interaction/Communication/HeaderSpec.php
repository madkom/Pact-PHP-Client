<?php

namespace spec\Madkom\PactClient\Domain\Interaction\Communication;

use Madkom\PactClient\Domain\Interaction\Communication\Header;
use Madkom\PactClient\PactException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class HeaderSpec
 * @package spec\Madkom\PactClient\Domain\Interaction\Communication
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 * @mixin Header
 */
class HeaderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Madkom\PactClient\Domain\Interaction\Communication\Header');
    }

    function it_should_return_empty_jsonSerialize()
    {
        $this->jsonSerialize()->shouldReturn([]);
    }

    function it_should_add_key_value()
    {
        $this->beConstructedWith(["name" => "Franek"]);

        $this->jsonSerialize()->shouldReturn([
            'name' => 'Franek'
        ]);
    }

    function it_should_add_multiple_key_values()
    {
        $this->beConstructedWith([
            "name"      => "Franek",
            "surname"   => "Edwin"
        ]);

        $this->jsonSerialize()->shouldReturn([
            'name'      => 'Franek',
            'surname'   => 'Edwin'
        ]);
    }

    function it_should_throw_exception_if_empty_key_or_value_passed()
    {
        $this->shouldThrow(PactException::class)->during('__construct', [['name' => '']]);
        $this->shouldThrow(PactException::class)->during('__construct', [['' => 'some']]);
        $this->shouldThrow(PactException::class)->during('__construct', [['' => '']]);
    }



}
