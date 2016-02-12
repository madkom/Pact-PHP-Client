<?php

namespace spec\Madkom\PactoClient\Domain\Interaction\Communication;

use Madkom\PactoClient\Application\Pact;
use Madkom\PactoClient\Domain\Interaction\Communication\Body;
use Madkom\PactoClient\PactoException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class BodySpec
 * @package spec\Madkom\PactoClient\Domain\Interaction\Communication
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 * @mixin Body
 */
class BodySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(\JsonSerializable::class);
    }

    function it_should_return_empty_data()
    {
        $this->jsonSerialize()->shouldReturn([]);
    }

    function it_should_add_key_value()
    {
        $this->add('name', 'Franek');

        $this->jsonSerialize()->shouldReturn([
            'name' => 'Franek'
        ]);
    }

    function it_should_add_multiple_key_values()
    {
        $this->add('name', 'Franek');
        $this->add('surname', 'Edwin');

        $this->jsonSerialize()->shouldReturn([
            'name'      => 'Franek',
            'surname'   => 'Edwin'
        ]);
    }

    function it_should_throw_exception_if_empty_key_or_value_passed()
    {
        $this->shouldThrow(PactoException::class)->during('add', ['name', '']);
        $this->shouldThrow(PactoException::class)->during('add', ['', 'some']);
        $this->shouldThrow(PactoException::class)->during('add', ['', '']);
        $this->shouldThrow(PactoException::class)->during('add', ['address', []]);
    }

    function it_should_add_nested_data()
    {
        $this->add('address', [
            'street' => 'WallStreet',
            'number' => '123'
        ]);

        $this->jsonSerialize()->shouldReturn([
            'address' => [
                'street' => 'WallStreet',
                'number' => '123'
            ]
        ]);
    }

//    function it_should_handle_matching_objects()
//    {
//        $this->add('name', Pact::like('some'));
//        $this->add('dateOfBirth', Pact::term("02/11/2013", "/\d{2}\/\d{2}\/\d{4}/"));
//        $this->add("children", Pact::eachLike(["name" => "Fred", "age" => 2]));
//        $this->add('age', 'some');
//
//        $this->jsonSerialize()->shouldReturn([
//            'name' => [
//                "json_class" => "Pact::SomethingLike",
//                "contents"   => "some"
//            ],
//            "dateOfBirth" => [
//                "json_class" => "Pact::Term",
//                "data" => [
//                    "generate" => "02/11/2013",
//                    "matcher" => [
//                        "json_class" => "Regexp",
//                        "o"          => 0,
//                        "s"          => "/\d{2}\/\d{2}\/\d{4}/"
//                    ]
//                ]
//            ],
//            "children" => [
//                "json_class" => "Pact::ArrayLike",
//                "contents"   => [
//                    "json_class" => "Pact::ArrayLike",
//                    "contents"
//                ]
//            ]
//        ]);
//    }

}
