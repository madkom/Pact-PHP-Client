<?php

namespace Madkom\PactClient\Domain\Interaction\Communication;

use Madkom\PactClient\PactException;

/**
 * Class Body
 * @package Madkom\PactClient\Domain\Interaction\Communication
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
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->data);
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->data;
    }

    /**
     * @param string $key
     * @param string $value
     *
     * @throws PactException
     */
    private function setSingleData($key, $value)
    {
        if ($this->isDataIncorrect($key) || $this->isDataIncorrect($value)) {
            throw new PactException("Key and values should'nt be empty");
        }

        $this->data[$key] = $value;
    }

    /**
     * @param mixed $data
     * @return bool
     */
    private function isDataIncorrect($data)
    {
        return (is_null($data) || $data === '') || (is_array($data) && empty($data));
    }

}
