<?php

namespace spec\Madkom\PactoClient\Application;

use Madkom\PactoClient\Application\ConsumerPactBuilder;
use Madkom\PactoClient\Application\Pact;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class ConsumerPactBuilderSpec
 * @package spec\Madkom\PactoClient\Application
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 * @mixin ConsumerPactBuilder
 */
class ConsumerPactBuilderSpec extends ObjectBehavior
{


    function it_is_initializable()
    {
        $this->shouldHaveType('Madkom\PactoClient\Application\ConsumerPactBuilder');
    }

    function it_should_set_provider_state()
    {
        $this
            ->given("An alligator named Mary exists")
            ->uponReceiving("A request for an alligator")
            ->with([
                "method" => "get",
                "path"   => "/alligators/Mary",
                "query" => [
                    "name" => "fred"
                ],
                "headers" => [
                    "Accept" => "application/json"
                ],
                "body" => [
                    "param" => 1
                ]
            ])
            ->willRespondWith([
                "status"    => 200,
                "headers"   => ["Content-Type" => "application/json"],
                "body"      => [
                    "name"      => "Mary",
                    "children"  => Pact::eachLike(["name" => "Fred", "age" => 2])
                ]
            ]);

        $interaction = $this->setup();
    }

}
