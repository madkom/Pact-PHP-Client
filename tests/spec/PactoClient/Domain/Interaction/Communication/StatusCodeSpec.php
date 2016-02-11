<?php

namespace spec\Madkom\PactoClient\Domain\Interaction\Communication;

use Madkom\PactoClient\Domain\Interaction\Communication\StatusCode;
use Madkom\PactoClient\PactoException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class StatusCodeSpec
 * @package spec\Madkom\PactoClient\Domain\Interaction\Communication
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 * @mixin StatusCode
 */
class StatusCodeSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith(200);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Madkom\PactoClient\Domain\Interaction\Communication\StatusCode');
    }

    function it_should_return_value_it_was_created_with()
    {
        $this->jsonSerialize()->shouldReturn(200);
    }

    public function it_should_throw_exception_if_wrong_method_passed()
    {
        $this->shouldThrow(PactoException::class)->during('__construct', ['']);
        $this->shouldThrow(PactoException::class)->during('__construct', [null]);
        $this->shouldThrow(PactoException::class)->during('__construct', ['NOT']);
        $this->shouldThrow(PactoException::class)->during('__construct', ['aaa']);
        $this->shouldThrow(PactoException::class)->during('__construct', [123]);
    }

    function it_should_not_exception_for_correct_method_types()
    {
        $this->shouldNotThrow(PactoException::class)->during('__construct', [StatusCode::OK_CODE]);
        $this->shouldNotThrow(PactoException::class)->during('__construct', [StatusCode::NOT_FOUND_CODE]);
        $this->shouldNotThrow(PactoException::class)->during('__construct', [204]);
    }

}
