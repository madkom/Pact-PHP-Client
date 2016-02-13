<?php

namespace Madkom\PactClient\Domain\Interaction\Communication;

use Madkom\PactClient\PactException;

/**
 * Class StatusCode
 * @package Madkom\PactClient\Domain\Interaction\Communication
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class StatusCode implements \JsonSerializable
{

    const CONTINUE_CODE = 100;
    const SWITCHING_PROTOCOL_CODE = 101;
    const PROCESSING_CODE = 102;
    const OK_CODE = 200;
    const CREATED_CODE = 201;
    const ACCEPTED_CODE = 202;
    const NO_CONTENT_CODE = 204;
    const MOVED_PERMANENTLY_CODE = 301;
    const NOT_MODIFIED_CODE = 304;
    const BAD_REQUEST_CODE = 400;
    const UNAUTHORIZED_CODE = 401;
    const FORBIDDEN_CODE = 403;
    const NOT_FOUND_CODE = 404;
    const CONFLICT_CODE = 409;
    const INTERNAL_SERVER_ERROR_CODE = 500;
    const BAD_GATEWAY_CODE = 502;
    const SERVICE_UNAVAILABLE_CODE = 503;

    /** @var  int */
    private $codeNumber;

    /**
     * Method constructor.
     *
     * @param int $codeNumber
     */
    public function __construct($codeNumber)
    {
        $this->setCodeNumber($codeNumber);
    }

    /**
     * @return int
     */
    public function jsonSerialize()
    {
        return $this->codeNumber;
    }

    /**
     * @param int $codeNumber
     *
     * @throws PactException
     */
    private function setCodeNumber($codeNumber)
    {
        $selfRfl = new \ReflectionClass($this);
        $constants = $selfRfl->getConstants();
        foreach ($constants as $constant) {
            if ($constant == $codeNumber) {
                $this->codeNumber = $codeNumber;
                return;
            }
        }

        throw new PactException("Passed Method codeNumber " . $codeNumber . " doesn't exists.");
    }



}
