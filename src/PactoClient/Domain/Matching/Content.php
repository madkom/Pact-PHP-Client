<?php

namespace Madkom\PactoClient\Domain\Matching;

use Madkom\PactoClient\PactoException;

/**
 * Class SingleContent
 * @package Madkom\PactoClient\Domain\Matching
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class Content
{

    /**
     * @var string
     */
    private $key;
    /**
     * @var int|string
     */
    private $value;

    /**
     * SingleContent constructor.
     *
     * @param string     $key
     * @param string|int $value
     */
    public function __construct($key, $value)
    {
        $this->setKey($key);
        $this->setValue($value);
    }

    /**
     * @return string
     */
    public function key()
    {
        return $this->key;
    }

    /**
     * @return int|string
     */
    public function value()
    {
        return $this->value;
    }

    /**
     * @param string $key
     *
     * @throws PactoException
     */
    private function setKey($key)
    {
        if (!$key) {
            throw new PactoException("Can't set empty key for Content");
        }

        $this->key = $key;
    }

    /**
     * @param string|int $value
     *
     * @throws PactoException
     */
    private function setValue($value)
    {
        if (!$value) {
            throw new PactoException("Can't set empty value for Content");
        }

        $this->value = $value;
    }

}
