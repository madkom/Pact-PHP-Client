<?php

namespace Madkom\PactoClient\Domain\Interaction\Communication;

use Madkom\PactoClient\PactoException;

/**
 * Class Path - Url Path for example "/client/1"
 * @package Madkom\PactoClient\Domain\Interaction\Communication
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
     * @throws PactoException
     */
    private function setUrlPath($urlPath)
    {
        if (preg_match("#^\/([^\/\s+](\/[^\/\s]+)*)#i", $urlPath)) {
            $this->value = $urlPath;
            return;
        };

        throw new PactoException('Passed url path is wrong ' . $urlPath);
    }

}
