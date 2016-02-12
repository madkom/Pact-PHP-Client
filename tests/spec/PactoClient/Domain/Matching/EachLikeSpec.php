<?php

namespace spec\Madkom\PactoClient\Domain\Matching;

use Madkom\PactoClient\Application\Pact;
use Madkom\PactoClient\Domain\Matching\EachLike;
use Madkom\PactoClient\Domain\Matching\Content;
use Madkom\PactoClient\PactoException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class EachLikeSpec
 * @package spec\Madkom\PactoClient\Domain\Matching
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 * @mixin EachLike
 * @link https://github.com/realestate-com-au/pact/wiki/v2-flexible-matching
 */
class EachLikeSpec extends ObjectBehavior
{

    /** @var  array */
    private $contents;
    /** @var  int */
    private $min;

    function let()
    {
        $this->contents = [new Content('name', 'Edward')];
        $this->min      = 1;
        $this->beConstructedWith($this->contents, $this->min);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(\JsonSerializable::class);
    }

    function it_should_return_as_ruby_object_when_created_with_one_content()
    {
        $this->jsonSerialize()->shouldReturn([
            "json_class" => "Pact::ArrayLike",
            "contents"   => [
                'name' => 'Edward'
            ],
            "min" => $this->min
        ]);
    }

    function it_should_provide_null_contents()
    {
        $this->beConstructedWith([], 1);

        $this->jsonSerialize()->shouldReturn([
            "json_class" => "Pact::ArrayLike",
            "contents"   => null,
            "min" => $this->min
        ]);
    }

//    function it_should_provide_array_of_content()
//    {
//        $contents = [new Content('name', 'Edward'), new Content('surname', 'Withbold')];
//        $this->beConstructedWith($contents, 2);
//
//        $this->jsonSerialize()->shouldReturn()
//    }

    function it_should_nest_like_matcher_correctly()
    {
        $this->beConstructedWith([new Content('id', Pact::like(10))], 1);

        $this->jsonSerialize()->shouldReturn([
            "json_class" => "Pact::ArrayLike",
            "contents" => [
                "id" => [
                    "json_class" => "Pact::SomethingLike",
                    "contents"   => 10
                ]
            ],
            "min" => 1
        ]);
    }

    function it_should_nest_term_matcher_correctly()
    {
        $this->beConstructedWith([new Content('colour', Pact::term("red", "red|green"))], 1);

        $this->jsonSerialize()->shouldReturn([
            "json_class" => "Pact::ArrayLike",
            "contents" => [
                "colour" => [
                    "json_class" => "Pact::Term",
                    "data" => [
                        "generate" => "red",
                        "matcher"  => [
                            "json_class" => "Regexp",
                            "o"          => 0,
                            "s"          => "red|green"
                        ]
                    ]
                ]
            ],
            "min" => 1
        ]);
    }

    function it_should_nest_each_like_matcher_correctly()
    {
        $this->beConstructedWith([new Content('colour', Pact::eachLike(["type" => 'nice']))], 1);

        $this->jsonSerialize()->shouldReturn([
            "json_class" => "Pact::ArrayLike",
            "contents" => [
                "colour" => [
                    "json_class" => "Pact::ArrayLike",
                    "contents" => [
                        "type" => "nice"
                    ],
                    "min" => 1
                ]
            ],
            "min" => 1
        ]);
    }

    function it_should_next_next_multiple_matchers_correctly()
    {
        $this->beConstructedWith(
            [
                new Content("size", Pact::like(10)),
                new Content("colour", Pact::term("red", "red|green|blue")),
                new Content("tag", Pact::eachLike([
                    Pact::like("jumper"),
                    Pact::like("shirt")
                ], 2))
            ], 1
        );

        $this->jsonSerialize()->shouldReturn([
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
        ]);
    }

    function it_should_throw_exception_when_wrong_min_value_passed()
    {
        $this->shouldThrow(PactoException::class)->during('__construct', [$this->contents, 0]);
        $this->shouldThrow(PactoException::class)->during('__construct', [$this->contents, -5]);
        $this->shouldThrow(PactoException::class)->during('__construct', [$this->contents, null]);
        $this->shouldThrow(PactoException::class)->during('__construct', [$this->contents, '']);
        $this->shouldThrow(PactoException::class)->during('__construct', [$this->contents, 'fail']);
    }

    function it_should_throw_exception_if_passed_wrong_types()
    {
        $this->shouldThrow(PactoException::class)->during('__construct', [[new \stdClass()], 2]);
        $this->shouldThrow(PactoException::class)->during('__construct', [['some'], 2]);
    }

}
