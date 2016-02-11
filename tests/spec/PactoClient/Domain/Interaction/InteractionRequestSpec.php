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
        $this->jsonSerialize()->shouldReturn([
            "method"    => "post",
            "path"      => "/client",
            "headers"   => [],
            "body"      => []
        ]);
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

        $this->method()->shouldReturn($method);
        $this->path()->shouldReturn($path);
        $this->body()->shouldReturn($body);
        $this->header()->shouldReturn($header);
        $this->query()->shouldReturn($query);

        $this->jsonSerialize()->shouldReturn([
            "method"    => "post",
            "path"      => "/path",
            "headers"   => [],
            "body"      => []
        ]);
    }

}
