<?php

namespace Madkom\PactClient\Http\Service;

use GuzzleHttp\Psr7\Request;
use Madkom\PactClient\Domain\Interaction\Interaction;

/**
 * Class InteractionToPsrRequest
 * @package Madkom\PactClient\Http\Service
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class RequestBuilder
{
    /**
     * @var string
     */
    private $host;

    /**
     * RequestBuilder constructor.
     *
     * @param string $host
     */
    public function __construct($host)
    {
        $this->host = $host;
    }

    /**
     * Build request for creating new interaction
     *
     * @param Interaction $interaction
     *
     * @return Request
     */
    public function buildCreateInteractionRequest(Interaction $interaction)
    {

        return new Request(
            "POST",
            $this->host . "/interactions",
            [
                "X-Pact-Mock-Service" => true,
                "Content-Type"        => "application/json"
            ],
            json_encode($interaction)
        );
    }

    /**
     *  Builds request, which is responsible for removing expectations made by verify request
     *
     * @return Request
     */
    public function buildRemoveExpectationsRequest()
    {

        return new Request(
            "DELETE",
            $this->host . "/interactions",
            [
                "X-Pact-Mock-Service" => true
            ]
        );
    }

    /**
     * Builds request, which is responsible for verifying interactions.
     *
     * @return Request
     */
    public function buildVerifyInteractionRequest()
    {

        return new Request(
            "GET",
            $this->host . "/interactions/verification",
            [
                "X-Pact-Mock-Service" => true
            ]
        );
    }

    /**
     * Builds request for ending testing process for specific provider
     *
     * @param string        $consumerName
     * @param string        $providerName
     * @param string|null   $contractDir
     *
     * @return Request
     */
    public function buildEndProviderTestRequest($consumerName, $providerName, $contractDir = null)
    {
        $data = [
            "consumer" => [
                "name" => $consumerName
            ],
            "provider" => [
                "name" => $providerName
            ]
        ];

        if (!is_null($contractDir)) {
            $data["pact_dir"] = $contractDir;
        }

        return new Request(
            "POST",
            $this->host . "/pact",
            [
                "X-Pact-Mock-Service" => true
            ],
            json_encode($data)
        );
    }



}
