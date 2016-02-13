<?php

namespace spec\Madkom\PactClient\Application;

use Madkom\PactClient\Application\ConsumerPactBuilder;
use Madkom\PactClient\Application\Pact;
use Madkom\PactClient\Domain\Interaction\Interaction;
use Madkom\PactClient\Domain\Interaction\InteractionFactory;
use Madkom\PactClient\PactException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class ConsumerPactBuilderSpec
 * @package spec\Madkom\PactClient\Application
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 * @mixin ConsumerPactBuilder
 */
class ConsumerPactBuilderSpec extends ObjectBehavior
{

    /** @var  InteractionFactory */
    private $interactionFactory;

    function let(InteractionFactory $interactionFactory)
    {
        $this->interactionFactory = $interactionFactory;

        $this->beConstructedWith($this->interactionFactory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Madkom\PactClient\Application\ConsumerPactBuilder');
    }

    function it_should_set_provider_state(Interaction $interaction)
    {
        $this->interactionFactory->create(
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

        $consumerPactBuilder = $this
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

        $interaction = $consumerPactBuilder->interactionFromBuild();

        $interaction->shouldHaveType(Interaction::class);
    }

    function it_should_throw_exception_if_setting_up_not_finished_pact()
    {
        $this->shouldThrow(PactException::class)->during('interactionFromBuild');
    }

    function it_should_throw_exception_if_setting_up_not_finished_pact_with_only_given()
    {
        $this->given("An alligator named Mary exists");

        $this->shouldThrow(PactException::class)->during('interactionFromBuild');
    }

    function it_should_throw_exception_if_setting_up_no_finished_pact_with_given_and_receiving()
    {
        $this
            ->given("An alligator named Mary exists")
            ->uponReceiving("Request for alligator")
        ;

        $this->shouldThrow(PactException::class)->during('interactionFromBuild');
    }

    function it_should_throw_exception_if_setting_up_no_finished_pact_without_response()
    {
        $this
            ->given("An alligator named Mary exists")
            ->uponReceiving("Request for alligator")
            ->with([])
        ;

        $this->shouldThrow(PactException::class)->during('interactionFromBuild');
    }

    function it_should_throw_exception_if_setting_up_no_finished_pact_without_request()
    {
        $this
            ->given("An alligator named Mary exists")
            ->uponReceiving("Request for alligator")
            ->willRespondWith([])
        ;

        $this->shouldThrow(PactException::class)->during('interactionFromBuild');
    }

    function it_should_return_new_instance_of_pact_builder_for_every_change(Interaction $interaction)
    {
        $consumerPactBuilder = $this->given("provider has cat");
        $consumerPactBuilder->shouldNotBe($this);

        $consumerPactBuilder2 = $consumerPactBuilder->uponReceiving("a request for cat");
        $consumerPactBuilder2->shouldNotBe($consumerPactBuilder);

        $consumerPactBuilder3 = $consumerPactBuilder2->with([
            "method" => "get",
            "path"   => "/alligators/Mary"
        ]);
        $consumerPactBuilder3->shouldNotBe($consumerPactBuilder2);

        $consumerPactBuilder4 = $consumerPactBuilder3->willRespondWith([
            "status" => 200
        ]);
        $consumerPactBuilder4->shouldNotBe($consumerPactBuilder3);

        $this->interactionFactory->create(
            "provider has cat",
            "a request for cat",
            [
                "method" => "get",
                "path"   => "/alligators/Mary"
            ],
            [
                "status"    => 200
            ]
        )->willReturn($interaction);

        $interaction = $consumerPactBuilder4->interactionFromBuild();
        $interaction->shouldHaveType(Interaction::class);
    }
}
