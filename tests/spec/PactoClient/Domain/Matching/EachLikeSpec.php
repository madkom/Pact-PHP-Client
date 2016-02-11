<?php

namespace spec\Madkom\PactoClient\Domain\Matching;

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

    function it_should_throw_exception_if_passed_wrong_types()
    {
        $this->shouldThrow(PactoException::class)->during('__construct', [[new \stdClass()], 2]);
        $this->shouldThrow(PactoException::class)->during('__construct', [['some'], 2]);
    }

}
