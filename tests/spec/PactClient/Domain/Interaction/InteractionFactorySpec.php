<?php

namespace spec\Madkom\PactClient\Domain\Interaction;

use Madkom\PactClient\Application\Pact;
use Madkom\PactClient\Domain\Interaction\Interaction;
use Madkom\PactClient\Domain\Interaction\InteractionFactory;
use Madkom\PactClient\PactException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class InteractionFactorySpec
 * @package spec\Madkom\PactClient\Domain\Interaction
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 * @mixin InteractionFactory
 */
class InteractionFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Madkom\PactClient\Domain\Interaction\InteractionFactory');
    }

    function it_should_return_create_interaction_object()
    {
        $interaction = $this->create("provider info", "request info", [
            "method" => "get",
            "path"   => "/alligators/Mary",
            "query" => [
                "name" => "fred"
            ],
            "headers" => [
                "Accept" => "application/json"
            ],
            "body" => [
                "param" => 1
            ]
        ], [
            "status"    => 200,
            "headers"   => ["Content-Type" => "application/json"],
            "body"      => [
                "name"      => "Mary",
                "children"  => Pact::eachLike(["name" => "Fred", "age" => 2])
            ]
        ]);

        $interaction->shouldHaveType(Interaction::class);

        \PHPUnit_Framework_Assert::assertEquals(json_encode([
            "description"       => "request info",
            "provider_state"    => "provider info",
            "request" => [
                "method" => "get",
                "path"   => "/alligators/Mary",
                "query"  => [
                    "name" => "fred"
                ],
                "headers" => [
                    "Accept" => "application/json"
                ],
                "body" => [
                    "param" => 1
                ]
            ],
            "response" => [
                "status"    => 200,
                "headers"   => ["Content-Type" => "application/json"],
                "body"      => [
                    "name"      => "Mary",
                    "children"  => [
                        "json_class" => "Pact::ArrayLike",
                        "contents" => [
                            "name" => "Fred",
                            "age"  => 2
                        ],
                        "min" => 1
                    ]
                ]
            ]
        ]), json_encode($interaction->getWrappedObject()));
    }

    function it_should_throw_exception_if_no_method_passed()
    {
        $this->shouldThrow(PactException::class)->during('create', ["provider info", "request info", [
            "path"   => "/alligators/Mary",
            "query" => [
                "name" => "fred"
            ],
            "headers" => [
                "Accept" => "application/json"
            ],
            "body" => [
                "param" => 1
            ]
        ], [
            "status"    => 200,
            "headers"   => ["Content-Type" => "application/json"],
            "body"      => [
                "name"      => "Mary",
                "children"  => Pact::eachLike(["name" => "Fred", "age" => 2])
            ]
        ]]);
    }

    function it_should_throw_exception_if_no_path_passed()
    {
        $this->shouldThrow(PactException::class)->during('create', ["provider info", "request info", [
            "method" => "get",
            "query" => [
                "name" => "fred"
            ],
            "headers" => [
                "Accept" => "application/json"
            ],
            "body" => [
                "param" => 1
            ]
        ], [
            "status"    => 200,
            "headers"   => ["Content-Type" => "application/json"],
            "body"      => [
                "name"      => "Mary",
                "children"  => Pact::eachLike(["name" => "Fred", "age" => 2])
            ]
        ]]);
    }

    function it_should_provide_default_values_for_request()
    {
        $interaction = $this->create("provider info", "request info", [
            "method" => "get",
            "path"   => "/client"
        ], [
            "status"    => 204
        ]);

        $interaction->shouldHaveType(Interaction::class);

        \PHPUnit_Framework_Assert::assertEquals(json_encode([
            "description"       => "request info",
            "provider_state"    => "provider info",
            "request" => [
                "method" => "get",
                "path"   => "/client"
            ],
            "response" => [
                "status"    => 204
            ]
        ]), json_encode($interaction->getWrappedObject()));
    }

    function it_should_throw_exception_if_no_status_code_passed()
    {
        $this->shouldThrow(PactException::class)->during('create', ["provider info", "request info",
        [
            "method" => "get",
            "path"   => "/client",
            "query" => [
                "name" => "fred"
            ],
            "headers" => [
                "Accept" => "application/json"
            ],
            "body" => [
                "param" => 1
            ]
        ], [
            "headers"   => ["Content-Type" => "application/json"],
            "body"      => [
                "name"      => "Mary",
                "children"  => Pact::eachLike(["name" => "Fred", "age" => 2])
            ]
        ]]);
    }

}
