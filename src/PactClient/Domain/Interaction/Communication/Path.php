<?php

namespace Madkom\PactClient\Domain\Interaction\Communication;

use Madkom\PactClient\PactException;

/**
 * Class Path - Url Path for example "/client/1"
 * @package Madkom\PactClient\Domain\Interaction\Communication
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class Path implements \JsonSerializable
{

    /** @var  string */
    private $value;

    /**
     * Path constructor.
     *
     * @param string $urlPath
     */
    public function __construct($urlPath)
    {
        $this->setUrlPath($urlPath);
    }

    /**
     * @return string
     */
    public function jsonSerialize()
    {
        return $this->value;
    }

    /**
     * @param string $urlPath
     *
     * @throws PactException
     */
    private function setUrlPath($urlPath)
    {
        if (preg_match("#^\/([^\/\s+](\/[^\/\s]+)*)#i", $urlPath)) {
            $this->value = $urlPath;
            return;
        };

        throw new PactException('Passed url path is wrong ' . $urlPath);
    }

}
