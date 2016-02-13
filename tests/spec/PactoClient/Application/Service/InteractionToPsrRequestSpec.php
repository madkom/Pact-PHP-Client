<?php

namespace spec\Madkom\PactoClient\Application\Service;

use Madkom\PactoClient\Application\Service\InteractionToPsrRequest;
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
 * @package spec\Madkom\PactoClient\Application\Service
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 * @mixin InteractionToPsrRequest
 */
class InteractionToPsrRequestSpec extends ObjectBehavior
{

    function it_is_initializable()
    {
        $this->shouldHaveType('Madkom\PactoClient\Application\Service\InteractionToPsrRequest');
    }

    function it_should_create_new_psr_request_from_interaction()
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

        $psrRequest = $this->create($interaction);

        $psrRequest->shouldHaveType(\GuzzleHttp\Psr7\Request::class);

        $psrRequest->getMethod()->shouldReturn('POST');
        $psrRequest->getHeaders()->shouldReturn([
            "Host" => [
                "localhost:1234"
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
