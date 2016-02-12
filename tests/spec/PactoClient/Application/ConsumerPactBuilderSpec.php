<?php

namespace spec\Madkom\PactoClient\Application;

use Madkom\PactoClient\Application\ConsumerPactBuilder;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class ConsumerPactBuilderSpec
 * @package spec\Madkom\PactoClient\Application
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 * @mixin ConsumerPactBuilder
 */
class ConsumerPactBuilderSpec extends ObjectBehavior
{

    function it_is_initializable()
    {
        $this->shouldHaveType('Madkom\PactoClient\Application\ConsumerPactBuilder');
    }

    function it_should_set_provider_state()
    {
        $this->given("Something happens");
    }

}