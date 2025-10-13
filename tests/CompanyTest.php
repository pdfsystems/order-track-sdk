<?php

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Pdfsystems\OrderTrackSdk\Drivers\GuzzleDriver;
use Pdfsystems\OrderTrackSdk\Dtos\Company;
use Pdfsystems\OrderTrackSdk\OrderTrackClient;

it('can create companies', function () {
    $data = [
        'name' => 'Test Company',
    ];
    $mock = new MockHandler([
        new Response(200, ['content-type' => 'application/json'], json_encode($data)),
    ]);
    $client = new OrderTrackClient(new GuzzleDriver('test', handler: HandlerStack::create($mock)));
    $company = $client->companies()->create(new Company($data));
    expect($company)->toBeInstanceOf(Company::class);
});

it('can create companies with services', function () {
    $data = [
        'name' => 'Test Company',
        'services' => [
            ['service' => 'Test Service', 'data' => ['foo' => 'bar']],
        ],
    ];
    $mock = new MockHandler([
        new Response(200, ['content-type' => 'application/json'], json_encode($data)),
    ]);
    $client = new OrderTrackClient(new GuzzleDriver('test', handler: HandlerStack::create($mock)));
    $company = $client->companies()->create(new Company($data));
    expect($company)->toBeInstanceOf(Company::class)
        ->and($company->name)->toBe('Test Company')
        ->and($company->services)->toBeArray()
        ->and($company->services)->toHaveCount(1)
        ->and($company->services[0]->service)->toBe('Test Service')
        ->and($company->services[0]->data)->toBeArray()
        ->and($company->services[0]->data['foo'])->toBe('bar');
});

it('can load representation info', function () {
    $data = [[
        'rep_id' => 123,
        'distributor_id' => 456,
        'rep_code' => 'ABC',
    ]];
    $mock = new MockHandler([
        new Response(200, ['content-type' => 'application/json'], json_encode($data)),
    ]);
    $client = new OrderTrackClient(new GuzzleDriver('test', handler: HandlerStack::create($mock)));
    $representation = $client->companies()->representation();
    expect($representation)->toBeArray()
        ->and($representation)->toHaveCount(1)
        ->and($representation[0]->rep_id)->toBe(123)
        ->and($representation[0]->distributor_id)->toBe(456)
        ->and($representation[0]->rep_code)->toBe('ABC');
});
