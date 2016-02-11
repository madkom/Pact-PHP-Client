<?php

namespace spec\Madkom\PactoClient\Domain\Matching;

use Madkom\PactoClient\Domain\Matching\Like;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class SomethingLikeSpec
 * @package spec\Madkom\PactoClient\Domain\Matching
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 * @mixin Like
 */
class LikeSpec extends ObjectBehavior
{

    private $likeValue;

    function let()
    {
        $this->likeValue = 10;
        $this->beConstructedWith($this->likeValue);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(\JsonSerializable::class);
    }

    function it_should_return_as_ruby_object()
    {
        $this->jsonSerialize()->shouldReturn([
             "json_class" => "Pact::SomethingLike",
             "contents" => $this->likeValue
        ]);
    }

}
