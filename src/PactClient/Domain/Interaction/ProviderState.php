<?php

namespace Madkom\PactClient\Domain\Interaction;

use Madkom\PactClient\PactException;

/**
 * Class ProviderState
 * @package Madkom\PactClient\Domain\Interaction
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
     * @throws PactException
     */
    private function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return $this->value ? false : true;
    }

}
