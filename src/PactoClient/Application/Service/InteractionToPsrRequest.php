<?php

namespace Madkom\PactoClient\Application\Service;

use GuzzleHttp\Psr7\Request;
use Madkom\PactoClient\Domain\Interaction\Interaction;

/**
 * Class InteractionToPsrRequest
 * @package Madkom\PactoClient\Application\Service
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class InteractionToPsrRequest
{

    /**
     * @param Interaction $interaction
     *
     * @return Request
     */
    public function create(Interaction $interaction)
    {

        $request = new Request(
            "POST",
            "http://localhost:1234/interactions",
            [
                "X-Pact-Mock-Service" => true,
                "Content-Type"        => "application/json"
            ],
            json_encode($interaction)
        );

        return $request;
    }
}
