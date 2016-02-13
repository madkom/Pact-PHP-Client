<?php
require __DIR__ . '/../vendor/autoload.php';

$host = "localhost:1234";
$client = new \Http\Adapter\Guzzle6\Client();
$httpServiceCollaborator = new \Madkom\PactClient\Http\HttpMockServiceCollaborator($client, $host, "consumer_service", "provider_service");
$consumerPactBuilder     = new \Madkom\PactClient\Application\ConsumerPactBuilder(new \Madkom\PactClient\Domain\Interaction\InteractionFactory());

$interaction = $consumerPactBuilder
    ->given("Foo exists")
    ->uponReceiving('A request for foo')
    ->with([
        "method" => "get",
        "path"   => "/foo"
    ])
    ->willRespondWith([
        "status" => 200,
        "headers" => [
            "Content-Type" => "application/json"
        ],
        "body" => [
            "foo" => "bar"
        ]
    ])
    ->interactionFromBuild();

$httpServiceCollaborator->setupInteraction($interaction);


// Fake request from your application to provider
$request = new \GuzzleHttp\Psr7\Request("GET", $host . "/foo");
$client->sendRequest($request);

// Verifies if your pact you made was fulfilled by consumer (was this request ever send to mock_service)
$httpServiceCollaborator->verify();

$httpServiceCollaborator->finishProviderVerificationProcess();
