<?php

namespace Madkom\PactoClient\Domain\Interaction;

/**
 * Class Interaction
 * @package Madkom\PactoClient\Domain\Interaction
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class Interaction implements \JsonSerializable
{

    /**
     * @var ProviderState
     */
    private $providerState;
    /**
     * @var Description
     */
    private $description;
    /**
     * @var InteractionRequest
     */
    private $interactionRequest;
    /**
     * @var InteractionResponse
     */
    private $interactionResponse;

    /**
     * InteractionSpec constructor.
     *
     * @param ProviderState       $providerState
     * @param Description         $description
     * @param InteractionRequest  $interactionRequest
     * @param InteractionResponse $interactionResponse
     */
    public function __construct(ProviderState $providerState, Description $description, InteractionRequest $interactionRequest, InteractionResponse $interactionResponse)
    {
        $this->providerState = $providerState;
        $this->description = $description;
        $this->interactionRequest = $interactionRequest;
        $this->interactionResponse = $interactionResponse;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            "description"    => $this->description,
            "provider_state" => $this->providerState,
            "request"        => $this->interactionRequest,
            "response"       => $this->interactionResponse
        ];
    }

}
