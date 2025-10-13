<?php

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Pdfsystems\OrderTrackSdk\Drivers\GuzzleDriver;
use Pdfsystems\OrderTrackSdk\Dtos\Customer;
use Pdfsystems\OrderTrackSdk\Dtos\Pagination\CustomerList;
use Pdfsystems\OrderTrackSdk\Exceptions\NotFoundException;
use Pdfsystems\OrderTrackSdk\OrderTrackClient;
use Pdfsystems\OrderTrackSdk\Repositories\CustomersRepository;

it('can create customer repositories', function () {
    $client = new OrderTrackClient(new GuzzleDriver('test'));
    expect($client->customers())->toBeInstanceOf(CustomersRepository::class);
});

it('can search for customers', function () {
    $data = [
        'current_page' => 1,
        'data' => [
            [
                'id' => 1,
                'customer_number' => '1234',
                'name' => 'John Doe',
            ],
        ],
        'first_page_url' => 'https://example.com/page/1',
        'from' => 1,
        'last_page' => 1,
        'last_page_url' => 'https://example.com/page/1',
        'links' => [
        ],
        'next_page_url' => null,
        'path' => 'https://example.com',
        'per_page' => 1,
        'prev_page_url' => null,
        'to' => 1,
        'total' => 1,
    ];
    $mock = new MockHandler([
        new Response(200, ['content-type' => 'application/json'], json_encode($data)),
    ]);
    $client = new OrderTrackClient(new GuzzleDriver('test', handler: HandlerStack::create($mock)));
    $customers = $client->customers()->search();
    expect($customers)->toBeInstanceOf(CustomerList::class)
        ->and($customers->data)->toHaveCount(1)
        ->and($customers->data[0]->id)->toBe(1)
        ->and($customers->data[0]->customer_number)->toBe('1234')
        ->and($customers->data[0]->name)->toBe('John Doe');
});

it('can load individual customers by customer number', function () {
    $data = [
        'current_page' => 1,
        'data' => [
            [
                'id' => 1,
                'customer_number' => '1234',
                'name' => 'John Doe',
            ],
        ],
        'first_page_url' => 'https://example.com/page/1',
        'from' => 1,
        'last_page' => 1,
        'last_page_url' => 'https://example.com/page/1',
        'links' => [
        ],
        'next_page_url' => null,
        'path' => 'https://example.com',
        'per_page' => 1,
        'prev_page_url' => null,
        'to' => 1,
        'total' => 1,
    ];
    $mock = new MockHandler([
        new Response(200, ['content-type' => 'application/json'], json_encode($data)),
    ]);
    $client = new OrderTrackClient(new GuzzleDriver('test', handler: HandlerStack::create($mock)));
    $customer = $client->customers()->findByCustomerNumber('1234');
    expect($customer)->toBeInstanceOf(Customer::class)
        ->and($customer->id)->toBe(1)
        ->and($customer->customer_number)->toBe('1234')
        ->and($customer->name)->toBe('John Doe');
});

it('throws an exception loading nonexisting customer number', function () {
    $data = [
        'current_page' => 1,
        'data' => [],
        'first_page_url' => 'https://example.com/page/1',
        'from' => null,
        'last_page' => 1,
        'last_page_url' => 'https://example.com/page/1',
        'links' => [
        ],
        'next_page_url' => null,
        'path' => 'https://example.com',
        'per_page' => 1,
        'prev_page_url' => null,
        'to' => null,
        'total' => 0,
    ];
    $mock = new MockHandler([
        new Response(200, ['content-type' => 'application/json'], json_encode($data)),
    ]);
    $client = new OrderTrackClient(new GuzzleDriver('test', handler: HandlerStack::create($mock)));
    $client->customers()->findByCustomerNumber('FAKE');
})->throws(NotFoundException::class);
