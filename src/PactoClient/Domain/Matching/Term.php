<?php

namespace Madkom\PactoClient\Domain\Matching;

/**
 * Class Term - Can be used in Request and Response
 * @package Madkom\PactoClient\Domain\Matching
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 * @link https://github.com/realestate-com-au/pact/wiki/Regular-expressions-and-type-matching-with-Pact
 */
class Term implements \JsonSerializable
{
    /**
     * @var string
     */
    private $matcher;
    /**
     * @var string
     */
    private $generate;

    /**
     * Term constructor.
     *
     * @param string $generate
     * @param string $matcher
     */
    public function __construct($generate, $matcher)
    {
        $this->generate = $generate;
        $this->matcher = $matcher;
    }

    /**
     * @return array
     */
    function jsonSerialize()
    {
        return [
            "json_class" => "Pact::Term",
            "data" => [
                "generate" => $this->generate,
                "matcher" => [
                    "json_class" => "Regexp",
                    "o"          => 0,
                    "s"          => $this->matcher
                ]
            ]
        ];
    }

}
