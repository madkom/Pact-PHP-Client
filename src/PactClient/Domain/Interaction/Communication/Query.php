<?php

namespace Madkom\PactClient\Domain\Interaction\Communication;

/**
 * Class Query
 * @package Madkom\PactClient\Domain\Interaction\Communication
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 * @link https://github.com/realestate-com-au/pact/wiki/Understanding-Request-Matching
 */
class Query extends Body
{

    /** @var  string */
    private $queryString = null;

    /**
     * Query constructor.
     *
     * @param array|string $bodyData
     */
    public function __construct($bodyData = [])
    {
        if (!is_string($bodyData)) {
            parent::__construct($bodyData);
            return;
        }

        $this->queryString = $bodyData;
    }

    /**
     * @return array|string
     */
    function jsonSerialize()
    {
        if (is_null($this->queryString)) {
            return parent::jsonSerialize();
        }

        return $this->queryString;
    }

}
