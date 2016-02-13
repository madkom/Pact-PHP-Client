<?php

namespace Madkom\PactoClient\Domain\Interaction;

use Madkom\PactoClient\Domain\Interaction\Communication\Body;
use Madkom\PactoClient\Domain\Interaction\Communication\Header;
use Madkom\PactoClient\Domain\Interaction\Communication\StatusCode;

/**
 * Class InteractionResponse
 * @package Madkom\PactoClient\Domain\Interaction
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class InteractionResponse implements \JsonSerializable
{
    /**
     * @var StatusCode
     */
    private $statusCode;
    /**
     * @var Body|null
     */
    private $body;
    /**
     * @var Header|null
     */
    private $header;

    /**
     * InteractionResponse constructor.
     *
     * @param StatusCode  $statusCode
     * @param Body|null   $body
     * @param Header|null $header
     */
    public function __construct(StatusCode $statusCode, Body $body = null, Header $header = null)
    {
        $this->statusCode = $statusCode;
        $this->body = $body ? $body : new Body();
        $this->header = $header ? $header : new Header();
    }

    /**
     * @return array
     */
    function jsonSerialize()
    {
        $serializedJson = [
            "status" => $this->statusCode
        ];

        if (!$this->header->isEmpty()) {
            $serializedJson["headers"] = $this->header;
        }

        if (!$this->body->isEmpty()) {
            $serializedJson["body"] = $this->body;
        }

        return $serializedJson;
    }

}
