<?php

namespace spec\Madkom\PactoClient\Http;

use GuzzleHttp\Psr7\Request;
use Http\Client\HttpClient;
use Madkom\PactoClient\Application\ConsumerPactBuilder;
use Madkom\PactoClient\Http\HttpConsumerPactBuilder;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class ConsumerPactBuilderSpec
 * @package spec\Madkom\PactoClient\Http
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 * @mixin HttpConsumerPactBuilder
 */
class HttpConsumerPactBuilderSpec extends ObjectBehavior
{

    /** @var  HttpClient */
    private $client;

    function let(HttpClient $client)
    {
        $this->client = $client;
        $this->beConstructedWith($client, 'localhost', "service a", "service b");
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ConsumerPactBuilder::class);
    }

    function it_should_setup_interaction()
    {
        $this
            ->given("There is an alligator")
            ->uponReceiving("request for alligator")
            ->with([
                "method" => "get",
                "path"   => "/client"
            ])
            ->willRespondWith([
                "status" => 200
            ]);

        $this->client->sendRequest(Argument::type(Request::class))->shouldBeCalledTimes(2);

        $this->setupInteraction();
    }

    function it_should_validate_interaction()
    {
        $this->client->sendRequest(Argument::type(Request::class))->shouldBeCalledTimes(1);

        $this->verify();
    }

    function it_should_end_provider_verification_process()
    {
        $this->client->sendRequest(Argument::type(Request::class))->shouldBeCalledTimes(1);

        $this->finishProviderVerificationProcess();
    }

}
