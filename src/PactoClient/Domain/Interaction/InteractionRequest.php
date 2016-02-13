<?php

namespace Madkom\PactoClient\Domain\Interaction;

use Madkom\PactoClient\Domain\Interaction\Communication\Body;
use Madkom\PactoClient\Domain\Interaction\Communication\Header;
use Madkom\PactoClient\Domain\Interaction\Communication\Method;
use Madkom\PactoClient\Domain\Interaction\Communication\Path;
use Madkom\PactoClient\Domain\Interaction\Communication\Query;

/**
 * Class InteractionRequest
 * @package Madkom\PactoClient\Domain\Interaction
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class InteractionRequest implements \JsonSerializable
{
    /**
     * @var Method
     */
    private $method;
    /**
     * @var Path
     */
    private $path;
    /**
     * @var Body|null
     */
    private $body;
    /**
     * @var Header|null
     */
    private $header;
    /**
     * @var Query|null
     */
    private $query;

    /**
     * InteractionRequest constructor.
     *
     * @param Method      $method
     * @param Path        $path
     * @param Body        $body
     * @param Header      $header
     * @param Query       $query
     */
    public function __construct(Method $method, Path $path, Body $body, Header $header, Query $query)
    {
        $this->method = $method;
        $this->path = $path;
        $this->body = $body;
        $this->header = $header;
        $this->query = $query;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        $serializedJson = [
            "method"  => $this->method,
            "path"    => $this->path,
        ];

        if (!$this->query->isEmpty()) {
            $serializedJson["query"] = $this->query;
        }

        if (!$this->header->isEmpty()) {
            $serializedJson["headers"] = $this->header;
        }

        if (!$this->body->isEmpty()) {
            $serializedJson["body"] = $this->body;
        }

        return $serializedJson;
    }

}
