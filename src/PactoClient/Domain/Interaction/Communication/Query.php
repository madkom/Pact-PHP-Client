<?php

namespace Madkom\PactoClient\Domain\Interaction\Communication;

use Madkom\PactoClient\PactoException;

/**
 * Class Query
 * @package Madkom\PactoClient\Domain\Interaction\Communication
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class Query implements \JsonSerializable
{

    /** @var  [] */
    private $data = [];

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->data;
    }

    /**
     * Add value under key
     *
     * @param string       $key
     * @param string|array $value
     */
    public function add($key, $value)
    {
        $this->setSingleData($key, $value);
    }

    /**
     * @param string $key
     * @param string $value
     *
     * @throws PactoException
     */
    private function setSingleData($key, $value)
    {
        if (!$key || !$value) {
            throw new PactoException("Key and values for header should'nt be empty");
        }

        if (is_array($key) || is_array($value)) {
            throw new PactoException("Key or value for header can't be array");
        }

        $this->data[$key][] = $value;
    }

}
