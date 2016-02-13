<?php

namespace spec\Madkom\PactClient\Domain\Interaction;

use Madkom\PactClient\Domain\Interaction\Communication\Body;
use Madkom\PactClient\Domain\Interaction\Communication\Header;
use Madkom\PactClient\Domain\Interaction\Communication\StatusCode;
use Madkom\PactClient\Domain\Interaction\InteractionResponse;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class InteractionResponseSpec
 * @package spec\Madkom\PactClient\Domain\Interaction
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
            "status"    => 200
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
            "status"    => 200
        ]), json_encode($this->jsonSerialize()->getWrappedObject()));
    }

}
