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
     * @param Body|null   $body
     * @param Header|null $header
     * @param Query|null  $query
     */
    public function __construct(Method $method, Path $path, Body $body = null, Header $header = null, Query $query = null)
    {
        $this->method = $method;
        $this->path = $path;
        $this->body = $body ? $body : new Body();
        $this->header = $header ? $header : new Header();
        $this->query = $query ? $query : new Query();
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            "method"  => $this->method,
            "path"    => $this->path,
            "headers" => $this->header,
            "body"    => $this->body
        ];
    }

}
