<?php

namespace spec\Madkom\PactoClient\Application;

use Madkom\PactoClient\Application\ConsumerPactBuilder;
use Madkom\PactoClient\Application\Pact;
use Madkom\PactoClient\Domain\Interaction\Interaction;
use Madkom\PactoClient\Domain\Interaction\InteractionFactory;
use Madkom\PactoClient\PactoException;
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

    function let(InteractionFactory $interactionFactory, Interaction $interaction)
    {
        $interactionFactory->create(
            "An alligator named Mary exists",
            "A request for an alligator",
            [
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
            ],
            [
                "status"    => 200,
                "headers"   => ["Content-Type" => "application/json"],
                "body"      => [
                    "name"      => "Mary",
                    "children"  => Pact::eachLike(["name" => "Fred", "age" => 2])
                ]
            ]
        )->willReturn($interaction);

        $this->beConstructedWith($interactionFactory);
    }

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

        $interaction = $this->setupInteraction();

        $interaction->shouldHaveType(Interaction::class);
    }

    function it_should_throw_exception_if_setting_up_not_finished_pact()
    {
        $this->shouldThrow(PactoException::class)->during('setupInteraction');
    }

    function it_should_throw_exception_if_setting_up_not_finished_pact_with_only_given()
    {
        $this->given("An alligator named Mary exists");

        $this->shouldThrow(PactoException::class)->during('setupInteraction');
    }

    function it_should_throw_exception_if_setting_up_no_finished_pact_with_given_and_receiving()
    {
        $this
            ->given("An alligator named Mary exists")
            ->uponReceiving("Request for alligator")
        ;

        $this->shouldThrow(PactoException::class)->during('setupInteraction');
    }

    function it_should_throw_exception_if_setting_up_no_finished_pact_without_response()
    {
        $this
            ->given("An alligator named Mary exists")
            ->uponReceiving("Request for alligator")
            ->with([])
        ;

        $this->shouldThrow(PactoException::class)->during('setupInteraction');
    }

    function it_should_throw_exception_if_setting_up_no_finished_pact_without_request()
    {
        $this
            ->given("An alligator named Mary exists")
            ->uponReceiving("Request for alligator")
            ->willRespondWith([])
        ;

        $this->shouldThrow(PactoException::class)->during('setupInteraction');
    }

}
