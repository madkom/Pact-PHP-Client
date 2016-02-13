<?php

namespace Madkom\PactoClient\Http\Service;

use GuzzleHttp\Psr7\Request;
use Madkom\PactoClient\Domain\Interaction\Interaction;

/**
 * Class InteractionToPsrRequest
 * @package Madkom\PactoClient\Http\Service
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class RequestBuilder
{

    /**
     * @param string      $host
     * @param Interaction $interaction
     *
     * @return Request
     */
    public function buildCreateInteractionRequest($host, Interaction $interaction)
    {

        return new Request(
            "POST",
            $host . "/interactions",
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
     * @param string $host
     *
     * @return Request
     */
    public function buildRemoveExpectationsRequest($host)
    {

        return new Request(
            "DELETE",
            $host . "/interactions",
            [
                "X-Pact-Mock-Service" => true
            ]
        );
    }

    /**
     * Builds request, which is responsible for verifying interactions.
     *
     * @param string $host
     *
     * @return Request
     */
    public function buildVerifyInteractionRequest($host)
    {

        return new Request(
            "GET",
            $host . "/interactions/verification",
            [
                "X-Pact-Mock-Service" => true
            ]
        );
    }

    /**
     * Builds request for ending testing process for specific provider
     *
     * @param string $host
     * @param string $consumerName
     * @param string $providerName
     * @param string $contractDir
     *
     * @return Request
     */
    public function buildEndProviderTestRequest($host, $consumerName, $providerName, $contractDir)
    {
        return new Request(
            "POST",
            $host . "/pact",
            [
                "X-Pact-Mock-Service" => true
            ],
            json_encode([
                "consumer" => [
                    "name" => $consumerName
                ],
                "provider" => [
                    "name" => $providerName
                ],
                "pact_dir" => $contractDir
            ])
        );
    }



}
