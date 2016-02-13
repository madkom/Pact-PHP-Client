<?php

namespace Madkom\PactClient\Domain\Matching;

use Madkom\PactClient\PactException;

/**
 * Class EachLike
 * @package Madkom\PactClient\Domain\Matching
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
     * @throws PactException
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
     * @throws PactException
     */
    private function setMinValue($min)
    {
        if (!$min || $min < 1) {
            throw new PactException("Can't set minimum for EachLike lower than 1");
        }

        $this->min = $min;
    }

}
