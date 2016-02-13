<?php

namespace spec\Madkom\PactClient;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class PactExceptionSpec
 * @package spec\Madkom\PactClient
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class PactExceptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(\Exception::class);
    }
}
