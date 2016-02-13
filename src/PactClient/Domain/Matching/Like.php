<?php

namespace Madkom\PactClient\Domain\Matching;

/**
 * Class Like
 * @package Madkom\PactClient\Domain\Matching
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 * @link https://github.com/realestate-com-au/pact/wiki/Regular-expressions-and-type-matching-with-Pact
 */
class Like implements \JsonSerializable
{
    /**
     * @var int|string
     */
    private $likeValue;

    /**
     * Like constructor.
     *
     * @param string|int $likeValue
     */
    public function __construct($likeValue)
    {
        $this->likeValue = $likeValue;
    }

    /**
     * @return array
     */
    function jsonSerialize()
    {
        return [
            "json_class" => "Pact::SomethingLike",
            "contents"   => $this->likeValue
        ];
    }

}
