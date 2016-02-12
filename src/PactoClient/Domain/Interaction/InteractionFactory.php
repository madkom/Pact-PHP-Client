<?php

namespace Madkom\PactoClient\Domain\Interaction;

use Madkom\PactoClient\Domain\Interaction\Communication\Body;
use Madkom\PactoClient\Domain\Interaction\Communication\Header;
use Madkom\PactoClient\Domain\Interaction\Communication\Method;
use Madkom\PactoClient\Domain\Interaction\Communication\Path;
use Madkom\PactoClient\Domain\Interaction\Communication\Query;
use Madkom\PactoClient\Domain\Interaction\Communication\StatusCode;
use Madkom\PactoClient\PactoException;

/**
 * Class InteractionFactory
 * @package Madkom\PactoClient\Domain\Interaction
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class InteractionFactory
{


    /**
     * @param string $providerState
     * @param string $requestInformation
     * @param array  $requestData
     * @param array  $responseData
     *
     * @return Interaction
     */
    public function create($providerState, $requestInformation, array $requestData, array $responseData)
    {
        return new Interaction(
            new ProviderState($providerState),
            new Description($requestInformation),
            $this->createRequest($requestData),
            $this->createResponse($responseData)
        );
    }

    /**
     * @param array $requestData
     *
     * @return InteractionRequest
     * @throws PactoException
     */
    private function createRequest(array $requestData)
    {
        if (!array_key_exists('method', $requestData)) {
            throw new PactoException("Request data need to have 'method'");
        }

        if (!array_key_exists('path', $requestData)) {
            throw new PactoException("Request data need to have `path`");
        }

        return new InteractionRequest(
            new Method($requestData['method']),
            new Path($requestData['path']),
            new Body(array_key_exists('body', $requestData) ? $requestData['body'] : []),
            new Header(array_key_exists('headers', $requestData) ? $requestData['headers'] : []),
            new Query(array_key_exists('query', $requestData) ? $requestData['query'] : [])
        );
    }

    /**
     * @param array $responseData
     *
     * @return InteractionResponse
     * @throws PactoException
     */
    private function createResponse(array $responseData)
    {
        if (!array_key_exists('status', $responseData)) {
            throw new PactoException("Response data need to have `status`");
        }

        return new InteractionResponse(
            new StatusCode($responseData['status']),
            new Body(array_key_exists('body', $responseData) ? $responseData['body'] : []),
            new Header(array_key_exists('headers', $responseData) ? $responseData['headers'] : [])
        );
    }

}
