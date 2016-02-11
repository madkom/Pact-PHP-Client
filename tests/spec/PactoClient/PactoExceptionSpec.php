<?php

namespace spec\Madkom\PactoClient;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class PactoExceptionSpec
 * @package spec\Madkom\PactoClient
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class PactoExceptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(\Exception::class);
    }
}
