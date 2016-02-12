<?php

namespace Madkom\PactoClient\Domain\Matching;

use Madkom\PactoClient\PactoException;

/**
 * Class EachLike
 * @package Madkom\PactoClient\Domain\Matching
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class EachLike implements \JsonSerializable
{

    /**
     * @var array|Content[]
     */
    private $contents = [];
    /**
     * @var int
     */
    private $min;


    /**
     * EachLike constructor.
     *
     * @param array|object $contents
     * @param int           $min
     *
     * @throws PactoException
     */
    public function __construct($contents, $min)
    {
        $this->contents = $contents;
        $this->setMinValue($min);
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            "json_class" => "Pact::ArrayLike",
            "contents"   => $this->contents ? $this->contents : null,
            "min"        => $this->min
        ];
    }

    /**
     * @param int $min
     *
     * @throws PactoException
     */
    private function setMinValue($min)
    {
        if (!$min || $min < 1) {
            throw new PactoException("Can't set minimum for EachLike lower than 1");
        }

        $this->min = $min;
    }

}
