<?php

namespace Madkom\PactoClient\Domain\Interaction\Communication;

use Madkom\PactoClient\PactoException;

/**
 * Class Body
 * @package Madkom\PactoClient\Domain\Interaction\Communication
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class Body implements \JsonSerializable
{
    /** @var  string[]|int[]|\JsonSerializable[] */
    private $data = [];

    /**
     * Body constructor.
     *
     * @param array|object $bodyData
     */
    public function __construct($bodyData = [])
    {
        foreach ($bodyData as $key => $value) {
            $this->setSingleData($key, $value);
        }
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
            throw new PactoException("Key and values should'nt be empty");
        }

        $this->data[$key] = $value;
    }

    /**
     * @return array
     */
    function jsonSerialize()
    {
        return $this->data;
    }

}
