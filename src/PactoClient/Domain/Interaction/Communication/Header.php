<?php

namespace Madkom\PactoClient\Domain\Interaction\Communication;

use Madkom\PactoClient\PactoException;

/**
 * Class Header
 * @package Madkom\PactoClient\Domain\Interaction\Communication
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class Header implements \JsonSerializable
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
            throw new PactoException("Key and values should'nt be empty.");
        }

        if (is_array($key) || is_array($value)) {
            throw new PactoException("Key and values should'nt be array.");
        }

        $this->data[$key] = $value;
    }


}
