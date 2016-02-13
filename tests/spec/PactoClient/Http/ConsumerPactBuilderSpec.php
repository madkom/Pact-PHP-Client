<?php

namespace spec\Madkom\PactoClient\Http;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ConsumerPactBuilderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Madkom\PactoClient\Http\ConsumerPactBuilder');
    }
}
