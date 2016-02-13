<?php

namespace spec\Madkom\PactClient\Application;

use Madkom\PactClient\Application\Pact;
use Madkom\PactClient\Domain\Matching\EachLike;
use Madkom\PactClient\Domain\Matching\Like;
use Madkom\PactClient\Domain\Matching\Term;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class PactSpec
 * @package spec\Madkom\PactClient\Application
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 * @mixin Pact
 */
class PactSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Madkom\PactClient\Application\Pact');
    }

    function it_should_create_term_matching()
    {
        $term = $this->term("02/11/2013", "/\d{2}\/\d{2}\/\d{4}/");
        $term->shouldHaveType(Term::class);
    }

    function it_should_create_like_matching()
    {
        $like = $this->like(10);
        $like->shouldHaveType(Like::class);
    }

    function it_should_create_each_like_matching()
    {
        $eachLike = $this->eachLike([
            "name" => "Fred",
            "age"  => 2
        ]);

        $eachLike->shouldHaveType(EachLike::class);
        $eachLike->jsonSerialize()->shouldReturn([
            "json_class" => "Pact::ArrayLike",
            "contents"   => [
                "name" => "Fred",
                "age"  => 2
            ],
            "min" => 1
        ]);

        $eachLike = $this->eachLike([
            "name" => "Fred"
        ], 5);

        $eachLike->shouldHaveType(EachLike::class);
        $eachLike->jsonSerialize()->shouldReturn([
            "json_class" => "Pact::ArrayLike",
            "contents"   => [
                "name" => "Fred"
            ],
            "min" => 5
        ]);
    }

}
