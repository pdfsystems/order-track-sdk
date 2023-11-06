<?php

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Pdfsystems\OrderTrackSdk\Dtos\Company;
use Pdfsystems\OrderTrackSdk\OrderTrackClient;

it('can create companies', function () {
    $data = [
        'name' => 'Test Company',
    ];
    $mock = new MockHandler([
        new Response(200, ['content-type' => 'application/json'], json_encode($data)),
    ]);
    $client = new OrderTrackClient('test', handler: HandlerStack::create($mock));
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
    $client = new OrderTrackClient('test', handler: HandlerStack::create($mock));
    $company = $client->companies()->create(new Company($data));
    expect($company)->toBeInstanceOf(Company::class);
    expect($company->name)->toBe('Test Company');
    expect($company->services)->toBeArray();
    expect($company->services)->toHaveCount(1);
    expect($company->services[0]->service)->toBe('Test Service');
    expect($company->services[0]->data)->toBeArray();
    expect($company->services[0]->data['foo'])->toBe('bar');
});
