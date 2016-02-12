<?php

namespace spec\Madkom\PactoClient\Domain\Interaction;

use Madkom\PactoClient\Domain\Interaction\Communication\Body;
use Madkom\PactoClient\Domain\Interaction\Communication\Header;
use Madkom\PactoClient\Domain\Interaction\Communication\StatusCode;
use Madkom\PactoClient\Domain\Interaction\InteractionResponse;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class InteractionResponseSpec
 * @package spec\Madkom\PactoClient\Domain\Interaction
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 * @mixin InteractionResponse
 */
class InteractionResponseSpec extends ObjectBehavior
{

    function let()
    {
        $this->beConstructedWith(new StatusCode(StatusCode::OK_CODE));
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(\JsonSerializable::class);
    }

    function it_should_return_values_it_was_constructed_with()
    {
        \PHPUnit_Framework_Assert::assertEquals(json_encode([
            "status"    => 200,
            "headers"   => [],
            "body"      => []
        ]), json_encode($this->jsonSerialize()->getWrappedObject()));
    }

    function it_should_be_constructed_with_more_parameters()
    {
        $this->beConstructedWith(
            $statusCode = new StatusCode(StatusCode::OK_CODE),
            $body       = new Body(),
            $header     = new Header()
        );

        \PHPUnit_Framework_Assert::assertEquals(json_encode([
            "status"    => 200,
            "headers"   => [],
            "body"      => []
        ]), json_encode($this->jsonSerialize()->getWrappedObject()));
    }

}
