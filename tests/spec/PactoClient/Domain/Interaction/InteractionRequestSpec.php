<?php

namespace spec\Madkom\PactoClient\Domain\Interaction;

use Madkom\PactoClient\Domain\Interaction\Communication\Body;
use Madkom\PactoClient\Domain\Interaction\Communication\Header;
use Madkom\PactoClient\Domain\Interaction\Communication\Method;
use Madkom\PactoClient\Domain\Interaction\Communication\Path;
use Madkom\PactoClient\Domain\Interaction\Communication\Query;
use Madkom\PactoClient\Domain\Interaction\InteractionRequest;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class InteractionRequestSpec
 * @package spec\Madkom\PactoClient\Domain\Interaction
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 * @mixin InteractionRequest
 */
class InteractionRequestSpec extends ObjectBehavior
{

    function let()
    {
        $method = new Method(Method::POST);
        $path   = new Path('/client');
        $this->beConstructedWith($method, $path);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(\JsonSerializable::class);
    }

    function it_should_return_values_it_was_constructed_with()
    {
        \PHPUnit_Framework_Assert::assertEquals(json_encode([
            "method"    => "post",
            "path"      => "/client",
            "headers"   => [],
            "body"      => []
        ]), json_encode($this->jsonSerialize()->getWrappedObject()));
    }

    function it_should_be_constructable_with_more_parameters()
    {
        $this->beConstructedWith(
            $method = new Method(Method::POST),
            $path   = new Path('/path'),
            $body   = new Body(),
            $header = new Header(),
            $query  = new Query()
        );

        \PHPUnit_Framework_Assert::assertEquals(json_encode([
            "method"    => "post",
            "path"      => "/path",
            "headers"   => [],
            "body"      => []
        ]), json_encode($this->jsonSerialize()->getWrappedObject()));
    }

}
