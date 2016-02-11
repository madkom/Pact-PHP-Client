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
     * @param array $contents
     * @param int   $min
     *
     * @throws PactoException
     */
    public function __construct(array $contents, $min)
    {
        foreach ($contents as $content) {
            if (!($content instanceof Content)) {
                throw new PactoException("Passed content are not type of Content");
            }
            $this->contents[$content->key()] = $content->value();
        }

        $this->min      = $min;
    }

    /**
     * @return array
     */
    function jsonSerialize()
    {
        return [
            "json_class" => "Pact::ArrayLike",
            "contents"   => $this->contents,
            "min"        => $this->min
        ];
    }

}
