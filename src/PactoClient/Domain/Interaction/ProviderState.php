<?php

namespace Madkom\PactoClient\Domain\Interaction;

use Madkom\PactoClient\PactoException;

/**
 * Class ProviderState
 * @package Madkom\PactoClient\Domain\Interaction
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class ProviderState implements \JsonSerializable
{

    /** @var  string */
    private $value;

    /**
     * Description constructor.
     *
     * @param string $value
     */
    public function __construct($value)
    {
        $this->setValue($value);
    }

    /**
     * @return string
     */
    public function jsonSerialize()
    {
        return $this->value;
    }

    /**
     * @param string $value
     *
     * @throws PactoException
     */
    private function setValue($value)
    {
        if (!$value) {
            throw new PactoException("Can't create empty description of Provider State");
        }

        $this->value = $value;
    }

}
