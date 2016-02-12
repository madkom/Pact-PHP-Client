<?php

namespace Madkom\PactoClient\Domain\Interaction\Communication;

use Madkom\PactoClient\PactoException;

/**
 * Class Query
 * @package Madkom\PactoClient\Domain\Interaction\Communication
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 * @link https://github.com/realestate-com-au/pact/wiki/Understanding-Request-Matching
 */
class Query extends Body
{

    /**
     * Query constructor.
     *
     * @param array $bodyData
     */
    public function __construct(array $bodyData = [])
    {
        parent::__construct($bodyData);
    }

}
