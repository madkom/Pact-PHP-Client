<?php

namespace spec\Madkom\PactoClient\Domain\Interaction;

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
 * Class InteractionSpec
 * @package spec\Madkom\PactoClient\Domain\Interaction
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 * @mixin Interaction
 */
class InteractionSpec extends ObjectBehavior
{

    public function let(ProviderState $providerState, Description $description, InteractionRequest $interactionRequest, InteractionResponse $interactionResponse)
    {
        $this->beConstructedWith($providerState, $description, $interactionRequest, $interactionResponse);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(\JsonSerializable::class);
    }

    function it_should_return_as_array()
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

        $this->beConstructedWith($providerState, $description, $request, $response);

        $this->jsonSerialize()->shouldReturn(
            [
                "description"       => 'A request for foo',
                "provider_state"    => 'foo exists',
                "request" => [
                    "method"  => "get",
                    "path"    => "/client",
                    "headers" => [
                        "accept" => "application/json"
                    ],
                    "body" => [
                        "name" => "franek"
                    ]
                ],
                "response" => [
                    "status"  => 200,
                    "headers" => [
                        "Content-Type" => "application/json"
                    ],
                    "body" => []
                ]
            ]
        );
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
        $requestBody = new Body();
        foreach ($body as $key => $value) {
            $requestBody->add($key, $value);
        }
        $requestHeader = new Header();
        foreach ($header as $key => $value) {
            $requestHeader->add($key, $value);
        }
        $requestQuery = new Query();
        foreach ($query as $key => $value) {
            $requestQuery->add($key, $value);
        }

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
        $requestBody = new Body();
        foreach ($body as $key => $value) {
            $requestBody->add($key, $value);
        }
        $requestHeader = new Header();
        foreach ($header as $key => $value) {
            $requestHeader->add($key, $value);
        }

        return new InteractionResponse(new StatusCode($statusCode), $requestBody, $requestHeader);
    }

}
