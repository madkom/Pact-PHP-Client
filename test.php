<?php
require __DIR__ . "/vendor/autoload.php";


$builder = new \Madkom\PactoClient\Application\ConsumerPactBuilder(new \Madkom\PactoClient\Domain\Interaction\InteractionFactory());

$builder
    ->given("There is an alligator")
    ->uponReceiving("request for an alligator")
    ->with([
        'method' => 'get',
        'path'   => '/foo'
    ])
    ->willRespondWith([
        'status'    => 200,
        "headers"   => [
            "Content-Type" => "application/json"
        ],
        "body" => [
            "some" => "test"
        ]
    ]);

$interaction = $builder->setup();

$interactionToRequest = new \Madkom\PactoClient\Application\Service\InteractionToPsrRequest();

$request = $interactionToRequest->create($interaction);

$client = new \Http\Adapter\Guzzle6\Client();

$response = $client->sendRequest($request);
print_r($response->getStatusCode());
print_r($response->getBody()->getContents());