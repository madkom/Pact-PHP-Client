<?php

namespace spec\Madkom\PactoClient\Http;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Http\Client\HttpClient;
use Madkom\PactoClient\Application\ConsumerPactBuilder;
use Madkom\PactoClient\Http\HttpConsumerPactBuilder;
use Madkom\PactoClient\PactoException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Http\Message\StreamInterface;

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

    function it_should_setup_interaction(Response $response)
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

        $response->getStatusCode()->willReturn(200);
        $this->client->sendRequest(Argument::type(Request::class))->shouldBeCalledTimes(2)->willReturn($response);

        $this->setupInteraction();
    }

    function it_should_throw_exception_if_response_is_not_correct_for_interaction(Response $response, StreamInterface $stream)
    {
        $response->getStatusCode()->willReturn(500);

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

        $response->getBody()->willReturn($stream);
        $stream->getContents()->willReturn('Error');
        $this->client->sendRequest(Argument::type(Request::class))->shouldBeCalledTimes(1)->willReturn($response);

        $this->shouldThrow(PactoException::class)->during('setupInteraction');
    }

    function it_should_validate_interaction(Response $response)
    {
        $response->getStatusCode()->willReturn(200);
        $this->client->sendRequest(Argument::type(Request::class))->shouldBeCalledTimes(1)->willReturn($response);

        $this->verify();
    }

    function it_should_throw_exception_if_response_is_not_correct_for_verification_process(Response $response, StreamInterface $stream)
    {
        $response->getStatusCode()->willReturn(500);
        $response->getBody()->willReturn($stream);
        $stream->getContents()->willReturn('Error');
        $this->client->sendRequest(Argument::type(Request::class))->shouldBeCalledTimes(1)->willReturn($response);

        $this->shouldThrow(PactoException::class)->during('verify');
    }

    function it_should_end_provider_verification_process(Response $response)
    {
        $response->getStatusCode()->willReturn(200);
        $this->client->sendRequest(Argument::type(Request::class))->shouldBeCalledTimes(1)->willReturn($response);

        $this->finishProviderVerificationProcess();
    }

    function it_should_throw_exception_if_response_is_not_correct_for_finishing_the_verification_process(Response $response, StreamInterface $stream)
    {
        $response->getStatusCode()->willReturn(500);
        $response->getBody()->willReturn($stream);
        $stream->getContents()->willReturn('Error');
        $this->client->sendRequest(Argument::type(Request::class))->shouldBeCalledTimes(1)->willReturn($response);

        $this->shouldThrow(PactoException::class)->during('finishProviderVerificationProcess');
    }

}
