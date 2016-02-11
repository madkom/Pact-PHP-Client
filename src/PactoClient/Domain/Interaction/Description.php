<?php

namespace Madkom\PactoClient\Domain\Interaction;

use Madkom\PactoClient\PactoException;

/**
 * Class Description
 * @package Madkom\PactoClient\Domain\Interaction
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class Description implements \JsonSerializable
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
    function jsonSerialize()
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
            throw new PactoException("Can't create empty description");
        }

        $this->value = $value;
    }

}
