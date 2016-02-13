<?php

namespace Madkom\PactClient\Application;

use Madkom\PactClient\Domain\Interaction\InteractionFactory;
use Madkom\PactClient\PactException;

/**
 * Class ConsumerPactBuilder
 * Usage:
 * ->given
 * ->uponReceiving
 * ->with
 * ->willRespondWith
 * @package Madkom\PactClient\Application
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
final class ConsumerPactBuilder
{

    /** @var  string */
    private $providerState;

    /** @var  string */
    private $requestInformation;

    /** @var  array */
    private $requestData;

    /** @var  array */
    private $responseData;
    /**
     * @var InteractionFactory
     */
    private $interactionFactory;

    /**
     * ConsumerPactBuilder constructor.
     *
     * @param InteractionFactory $interactionFactory
     * @param null|string           $providerState
     * @param null|string           $requestInformation
     * @param null|[]               $requestData
     * @param null|[]               $responseData
     */
    public function __construct(InteractionFactory $interactionFactory, $providerState = null, $requestInformation = null, $requestData = null, $responseData = null)
    {
        $this->interactionFactory = $interactionFactory;

        $this->providerState        = $providerState;
        $this->requestInformation   = $requestInformation;
        $this->requestData          = $requestData;
        $this->responseData         = $responseData;
    }

    /**
     * Provider state while sending a request.
     * For example ("An alligator named Mary exists")
     *
     * @param string $providerState
     *
     * @return self
     */
    public function given($providerState)
    {
        return new self($this->interactionFactory, $providerState, $this->requestInformation, $this->requestData, $this->responseData);
    }

    /**
     * Request information for example ("A request for an alligator")
     *
     * @param string $requestInfo
     *
     * @return self
     */
    public function uponReceiving($requestInfo)
    {
        return new self($this->interactionFactory, $this->providerState, $requestInfo, $this->requestData, $this->responseData);
    }

    /**
     * Request data, which will be send to the consumer
     *
     *  Example:
     *  [
            "method" => "get",
            "path"   => "/alligators/Mary",
            "query" => [
                "name" => "fred"
            ]
            "headers" => [
                "Accept" => "application/json"
            ],
            "body" => [
                "param" => 1
            ]
        ]
     *
     * @param array $requestData
     *
     * @return self
     */
    public function with(array $requestData)
    {
        return new self($this->interactionFactory, $this->providerState, $this->requestInformation, $requestData, $this->responseData);
    }

    /**
     * Response data, which should be be received from provider after doing request
     *
     * Example:
     *  [
            "status"    => 200,
            "headers"   => ["Content-Type" => "application/json"],
            "body"      => [
                "name"      => "Mary",
                "children"  => Pact::eachLike(["name" => "Fred", "age" => 2])
            ]
        ]
     *
     * @param array $responseData
     *
     * @return self
     */
    public function willRespondWith(array $responseData)
    {
        return new self($this->interactionFactory, $this->providerState, $this->requestInformation, $this->requestData, $responseData);
    }

    /**
     * Provides interaction based on passed configuration
     *
     * @return \Madkom\PactClient\Domain\Interaction\Interaction
     * @throws PactException
     */
    public function interactionFromBuild()
    {
        if (!isset($this->providerState)) {
            throw new PactException("Before setting up, you need to set provider state");
        }

        if (!isset($this->requestInformation)) {
            throw new PactException("Before setting up, you need to set request information");
        }

        if (!isset($this->requestData)) {
            throw new PactException("Before setting up, you need to set request data");
        }

        if (!isset($this->responseData)) {
            throw new PactException("Before setting up, you need to set response data");
        }

        return $this->interactionFactory->create($this->providerState, $this->requestInformation, $this->requestData, $this->responseData);
    }

    
}
