<?php
require __DIR__ . '/../vendor/autoload.php';

$host = "localhost:1234";
$client = new \Http\Adapter\Guzzle6\Client();
$httpServiceCollaborator = new \Madkom\PactClient\Http\HttpMockServiceCollaborator($client, $host, "consumer_service_c", "provider_service_d");
$consumerPactBuilder     = new \Madkom\PactClient\Application\ConsumerPactBuilder(new \Madkom\PactClient\Domain\Interaction\InteractionFactory());

$interaction = $consumerPactBuilder
    ->given("user exists")
    ->uponReceiving('A request for user')
    ->with([
        "method" => "get",
        "path"   => "/user",
        "query"  => [
            "id" => "2"
        ],
        "headers" => [
            "Accept" => "application/json"
        ],
        "data" => [
            "type" => "admin"
        ]
    ])
    ->willRespondWith([
        "status" => 200,
        "headers" => [
            "Content-Type" => "application/json"
        ],
        "body" => [
            "foo" => \Madkom\PactClient\Application\Pact::eachLike([
                "name"      => \Madkom\PactClient\Application\Pact::like('Edward'),
                "favColor"   => \Madkom\PactClient\Application\Pact::term("red", "red|green|yellow")
            ])
        ]
    ])
    ->interactionFromBuild();

$httpServiceCollaborator->setupInteraction($interaction);


// Fake request from your application to provider
$request = new \GuzzleHttp\Psr7\Request("GET", $host . "/user?id=2", [
    "Accept" => "application/json"
], json_encode([
    "type" => "admin"
]));
$client->sendRequest($request);

// Verifies if your pact you made was fulfilled by consumer (was this request ever send to mock_service)
$httpServiceCollaborator->verify();

$httpServiceCollaborator->finishProviderVerificationProcess();