<?php

namespace spec\Madkom\PactoClient\Domain\Interaction\Communication;

use Madkom\PactoClient\Domain\Interaction\Communication\Query;
use Madkom\PactoClient\PactoException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class QuerySpec
 * @package spec\Madkom\PactoClient\Domain\Interaction\Communication
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 * @mixin Query
 */
class QuerySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Madkom\PactoClient\Domain\Interaction\Communication\Query');
    }

    function it_should_return_empty_jsonSerialize()
    {
        $this->jsonSerialize()->shouldReturn([]);
    }

    function it_should_add_key_value()
    {
        $this->add('name', 'Franek');

        $this->jsonSerialize()->shouldReturn([
            'name' => ['Franek']
        ]);
    }

    function it_should_add_multiple_key_values()
    {
        $this->add('name', 'Franek');
        $this->add('surname', 'Edwin');

        $this->jsonSerialize()->shouldReturn([
            'name'      => ['Franek'],
            'surname'   => ['Edwin']
        ]);
    }

    function it_should_return_multiple_values_if_under_same_key()
    {
        $this->add('name', 'John');
        $this->add('name', 'Edward');

        $this->jsonSerialize()->shouldReturn([
            'name' => ['John', 'Edward']
        ]);
    }

    function it_should_throw_exception_if_empty_key_or_value_passed()
    {
        $this->shouldThrow(PactoException::class)->during('add', ['name', '']);
        $this->shouldThrow(PactoException::class)->during('add', ['', 'some']);
        $this->shouldThrow(PactoException::class)->during('add', ['', '']);
        $this->shouldThrow(PactoException::class)->during('add', ['address', []]);
    }

    function it_should_add_nested_jsonSerialize()
    {
        $this->shouldThrow(PactoException::class)->during('add', ['name', [
            'street' => 'WallStreet',
            'number' => '123'
        ]]);
    }


}
