<?php

namespace spec\Madkom\PactClient\Domain\Matching;

use Madkom\PactClient\Domain\Matching\Term;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class TermSpec
 * @package spec\Madkom\PactClient\Domain\Matching
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 * @mixin Term
 */
class TermSpec extends ObjectBehavior
{

    /**
     * @var string
     */
    private $generate;
    /**
     * @var string
     */
    private $regex;

    function let()
    {
        $this->generate = "somethingToGenerate";
        $this->regex    = "\\w+";
        $this->beConstructedWith($this->generate, $this->regex);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(\JsonSerializable::class);
    }

    function it_should_return_term_as_ruby_object()
    {
        $this->jsonSerialize()->shouldReturn([
            "json_class" => "Pact::Term",
            "data" => [
                "generate" => $this->generate,
                "matcher"  => [
                    "json_class"=> "Regexp",
                    "o"         => 0,
                    "s"         => $this->regex
                ]
            ]
        ]);
    }

}
