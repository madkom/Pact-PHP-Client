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

    public function let()
    {
        $this->beConstructedWith([]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(\JsonSerializable::class);
    }

    function it_should_provide_information_if_empty_data()
    {
        $this->isEmpty()->shouldReturn(true);
    }

    function it_should_return_empty_data()
    {
        $this->jsonSerialize()->shouldReturn([]);
    }

    function it_should_add_key_value()
    {
        $this->beConstructedWith([
            "name" => "Franek"
        ]);

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
        $this->shouldThrow(PactoException::class)->during('__construct', [['name' => '']]);
        $this->shouldThrow(PactoException::class)->during('__construct', [['' => 'some']]);
        $this->shouldThrow(PactoException::class)->during('__construct', [['' => '']]);
        $this->shouldThrow(PactoException::class)->during('__construct', [['address' => []]]);
    }

    function it_should_add_nested_data()
    {
        $this->beConstructedWith([
            "address" => [
                'street' => 'WallStreet',
                'number' => '123'
            ]
        ]);

        $this->jsonSerialize()->shouldReturn([
            'address' => [
                'street' => 'WallStreet',
                'number' => '123'
            ]
        ]);
    }

    function it_should_handle_matching_objects()
    {
        $this->beConstructedWith([
            "name" => Pact::like('some'),
            'dateOfBirth' => Pact::term("02/11/2013", "/\d{2}\/\d{2}\/\d{4}/"),
            "children" => Pact::eachLike(["name" => "Fred", "age" => 2]),
            "age" => "some"
        ]);

        \PHPUnit_Framework_Assert::assertEquals(json_encode([
            'name' => [
                "json_class" => "Pact::SomethingLike",
                "contents"   => "some"
            ],
            "dateOfBirth" => [
                "json_class" => "Pact::Term",
                "data" => [
                    "generate" => "02/11/2013",
                    "matcher" => [
                        "json_class" => "Regexp",
                        "o"          => 0,
                        "s"          => "/\d{2}\/\d{2}\/\d{4}/"
                    ]
                ]
            ],
            "children" => [
                "json_class" => "Pact::ArrayLike",
                "contents"   => [
                    "name" => "Fred",
                    "age"  => 2
                ],
                "min" => 1
            ],
            "age" => "some"
        ]), json_encode($this->jsonSerialize()->getWrappedObject()));
    }

    function it_should_serialize_when_nested_values()
    {
        $this->beConstructedWith([
            "match" => Pact::eachLike(
                Pact::eachLike([
                    "size"      => Pact::like(10),
                    "colour"    => Pact::term("red", "red|green|blue"),
                    "tag"       => Pact::eachLike([
                        Pact::like("jumper"),
                        Pact::like("shirt")
                    ], 2)
                ])
            )
        ]);

        \PHPUnit_Framework_Assert::assertEquals(json_encode([
            "match" =>
                [
                    "json_class" => "Pact::ArrayLike",
                    "contents"   => [
                        "json_class" => "Pact::ArrayLike",
                        "contents" => [
                            "size" => [
                                "json_class" => "Pact::SomethingLike",
                                "contents"   => 10
                            ],
                            "colour" => [
                                "json_class" => "Pact::Term",
                                "data" => [
                                    "generate" => "red",
                                    "matcher" => [
                                        "json_class" => "Regexp",
                                        "o"          => 0,
                                        "s"          => "red|green|blue"
                                    ]
                                ]
                            ],
                            "tag" => [
                                "json_class" => "Pact::ArrayLike",
                                "contents"   => [
                                    [
                                        "json_class" => "Pact::SomethingLike",
                                        "contents" => "jumper"
                                    ],
                                    [
                                        "json_class" => "Pact::SomethingLike",
                                        "contents"   => "shirt"
                                    ]
                                ],
                                "min" => 2
                            ]
                        ],
                        "min" => 1
                    ],
                    "min" => 1
                ]
        ]), json_encode($this->jsonSerialize()->getWrappedObject()));
    }

}
