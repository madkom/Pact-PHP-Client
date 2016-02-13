<?php
require __DIR__ . '/../vendor/autoload.php';

$host = "localhost:1234";
$client = new \Http\Adapter\Guzzle6\Client();
$httpServiceCollaborator = new \Madkom\PactoClient\Http\HttpMockServiceCollaborator($client, $host, "consumer_service_A", "provider_service_B");
$consumerPactBuilder     = new \Madkom\PactoClient\Application\ConsumerPactBuilder(new \Madkom\PactoClient\Domain\Interaction\InteractionFactory());

$interaction = $consumerPactBuilder
    ->given("Bla exists")
    ->uponReceiving('A request for bla')
    ->with([
        "method" => "get",
        "path"   => "/bla"
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
$request = new \GuzzleHttp\Psr7\Request("GET", $host . "/bla");
$client->sendRequest($request);

// Verifies if your pact you made was fulfilled by consumer (was this request ever send to mock_service)
$httpServiceCollaborator->verify();

$interaction = $consumerPactBuilder
    ->given("Bla Bla exists")
    ->uponReceiving('A request for bla bla')
    ->with([
        "method" => "get",
        "path"   => "/bla/bla"
    ])
    ->willRespondWith([
        "status" => 200,
        "headers" => [
            "Content-Type" => "application/json"
        ],
        "body" => [
            "foo" => "fobar"
        ]
    ])
    ->interactionFromBuild();

$httpServiceCollaborator->setupInteraction($interaction);

$request = new \GuzzleHttp\Psr7\Request("GET", $host . "/bla/bla");
$client->sendRequest($request);

$httpServiceCollaborator->verify();


$httpServiceCollaborator->finishProviderVerificationProcess();
