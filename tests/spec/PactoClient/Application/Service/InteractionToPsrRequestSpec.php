<?php

namespace spec\Madkom\PactoClient\Application\Service;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class InteractionToPsrRequestSpec
 * @package spec\Madkom\PactoClient\Application\Service
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class InteractionToPsrRequestSpec extends ObjectBehavior
{

    function let()
    {

    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Madkom\PactoClient\Application\Service\InteractionToPsrRequest');
    }
}
