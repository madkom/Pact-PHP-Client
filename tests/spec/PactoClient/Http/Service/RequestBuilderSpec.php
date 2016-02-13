<?php

namespace spec\Madkom\PactoClient\Http\Service;

use Madkom\PactoClient\Http\Service\RequestBuilder;
use Madkom\PactoClient\Domain\Interaction\Communication\Body;
use Madkom\PactoClient\Domain\Interaction\Communication\Header;
use Madkom\PactoClient\Domain\Interaction\Communication\Method;
use Madkom\PactoClient\Domain\Interaction\Communication\Path;
use Madkom\PactoClient\Domain\Interaction\Communication\Query;
use Madkom\PactoClient\Domain\Interaction\Communication\StatusCode;
use Madkom\PactoClient\Domain\Interaction\Description;
use Madkom\PactoClient\Domain\Interaction\Interaction;
use Madkom\PactoClient\Domain\Interaction\InteractionRequest;
use Madkom\PactoClient\Domain\Interaction\InteractionResponse;
use Madkom\PactoClient\Domain\Interaction\ProviderState;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class InteractionToPsrRequestSpec
 * @package spec\Madkom\PactoClient\Http\Service
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 * @mixin RequestBuilder
 */
class RequestBuilderSpec extends ObjectBehavior
{

    /** @var  string */
    private $host;

    function let()
    {
        $this->host = 'localhost:1234';
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Madkom\PactoClient\Http\Service\RequestBuilder');
    }

    function it_should_build_request_for_creating_interaction()
    {
        $description   = new Description('A request for foo');
        $providerState = new ProviderState('foo exists');
        $request = $this->createRequest(Method::GET, '/client', [
            "name" => "franek"
        ], [
            "accept" => "application/json"
        ]);
        $response = $this->createResponse(StatusCode::OK_CODE, [], [
            "Content-Type" => "application/json"
        ]);
        $interaction = new Interaction($providerState, $description, $request, $response);

        $psrRequest = $this->buildCreateInteractionRequest($this->host, $interaction);

        $psrRequest->shouldHaveType(\GuzzleHttp\Psr7\Request::class);
        $psrRequest->getMethod()->shouldReturn('POST');
        $psrRequest->getHeaders()->shouldReturn([
            "Host" => [
                $this->host
            ],
            "X-Pact-Mock-Service" => [
                "1"
            ],
            "Content-Type"        => [
                "application/json"
            ]
        ]);
        $psrRequest->getRequestTarget()->shouldReturn("/interactions");
    }

    function it_should_build_request_for_removing_expectations()
    {
        $psrRequest = $this->buildRemoveExpectationsRequest($this->host);

        $psrRequest->shouldHaveType(\GuzzleHttp\Psr7\Request::class);
        $psrRequest->getMethod()->shouldReturn('DELETE');
        $psrRequest->getHeaders()->shouldReturn([
            "Host" => [
                $this->host
            ],
            "X-Pact-Mock-Service" => [
                "1"
            ]
        ]);
        $psrRequest->getRequestTarget()->shouldReturn("/interactions");
    }

    function it_should_build_request_for_verifying_interaction()
    {
        $psrRequest = $this->buildVerifyInteractionRequest($this->host);

        $psrRequest->shouldHaveType(\GuzzleHttp\Psr7\Request::class);
        $psrRequest->getMethod()->shouldReturn('GET');
        $psrRequest->getHeaders()->shouldReturn([
            "Host" => [
                $this->host
            ],
            "X-Pact-Mock-Service" => [
                "1"
            ]
        ]);
        $psrRequest->getRequestTarget()->shouldReturn("/interactions/verification");
    }

    function it_should_build_request_for_creating_contract_and_ending_testing_process_for_provider()
    {
        $consumerName = 'Service A';
        $providerName = 'Service B';
        $contractCatalogPath = '/tmp/contracts';

        $psrRequest = $this->buildEndProviderTestRequest($this->host, $consumerName, $providerName, $contractCatalogPath);

        $psrRequest->shouldHaveType(\GuzzleHttp\Psr7\Request::class);
        $psrRequest->getMethod()->shouldReturn('POST');
        $psrRequest->getHeaders()->shouldReturn([
            "Host" => [
                $this->host
            ],
            "X-Pact-Mock-Service" => [
                "1"
            ]
        ]);
        $psrRequest->getBody()->getContents()->shouldReturn(json_encode([
            "consumer" => [
                "name" => $consumerName
            ],
            "provider" => [
                "name" => $providerName
            ],
            "pact_dir" => $contractCatalogPath
        ]));
        $psrRequest->getRequestTarget()->shouldReturn("/pact");
    }

    /**
     * @param string $method
     * @param string $path
     * @param array $body
     * @param array $header
     * @param array $query
     *
     * @return InteractionRequest
     */
    private function createRequest($method, $path, array $body = [], array $header = [], array $query = [])
    {
        $requestBody = new Body($body);
        $requestHeader = new Header($header);
        $requestQuery = new Query($query);

        return new InteractionRequest(new Method($method), new Path($path), $requestBody, $requestHeader, $requestQuery);
    }

    /**
     * @param int   $statusCode
     * @param array $body
     * @param array $header
     *
     * @return InteractionResponse
     */
    private function createResponse($statusCode, array $body = [], array $header = [])
    {
        $requestBody = new Body($body);
        $requestHeader = new Header($header);

        return new InteractionResponse(new StatusCode($statusCode), $requestBody, $requestHeader);
    }

}