<?php

namespace Madkom\PactoClient\Domain\Interaction\Communication;

use Madkom\PactoClient\PactoException;

/**
 * Class Method
 * @package Madkom\PactoClient\Domain\Interaction\Communication
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class Method implements \JsonSerializable
{

    const GET  = 'get';
    const POST = 'post';
    const PUT  = 'put';
    const DELETE = 'delete';

    /**
     * @var string
     */
    private $type;

    /**
     * Method constructor.
     *
     * @param string $methodType
     */
    public function __construct($methodType)
    {
        $this->setType($methodType);
    }

    /**
     * @return string
     */
    public function jsonSerialize()
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @throws PactoException
     */
    private function setType($type)
    {
        $type = strtolower($type);

        $selfRfl = new \ReflectionClass($this);
        $constants = $selfRfl->getConstants();
        foreach ($constants as $constant) {
            if ($constant == $type) {
                $this->type = $type;
                return;
            }
        }

        throw new PactoException("Passed Method type " . $type . " doesn't exists.");
    }

}
