<?php

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Pdfsystems\OrderTrackSdk\Drivers\GuzzleDriver;
use Pdfsystems\OrderTrackSdk\Dtos\Order;
use Pdfsystems\OrderTrackSdk\Dtos\Pagination\OrderList;
use Pdfsystems\OrderTrackSdk\Enums\OrderStatus;
use Pdfsystems\OrderTrackSdk\Enums\OrderType;
use Pdfsystems\OrderTrackSdk\Exceptions\NotFoundException;
use Pdfsystems\OrderTrackSdk\OrderTrackClient;
use Pdfsystems\OrderTrackSdk\Repositories\OrdersRepository;

it('can create order repositories', function () {
    $client = new OrderTrackClient(new GuzzleDriver('test'));
    expect($client->orders())->toBeInstanceOf(OrdersRepository::class);
});

it('can search for orders', function () {
    $data = [
        'current_page' => 1,
        'data' => [
            [
                'id' => 1,
                'order_number' => 123456,
                'date_entered' => '2023-01-01',
                'status' => 'open',
                'type' => 'order',
                'rep_code' => 'ABC',
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
    $products = $client->orders()->search();
    expect($products)->toBeInstanceOf(OrderList::class)
        ->and($products->data)->toHaveCount(1);
});

it('can load individual orders by order number', function () {
    $data = [
        'current_page' => 1,
        'data' => [
            [
                'id' => 1,
                'order_number' => 123456,
                'date_entered' => '2023-01-01',
                'status' => 'open',
                'type' => 'order',
                'rep_code' => 'ABC',
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
    $order = $client->orders()->findByOrderNumber('123456');
    expect($order)->toBeInstanceOf(Order::class)
        ->and($order->id)->toBe(1)
        ->and($order->order_number)->toBe('123456')
        ->and($order->status)->toBe(OrderStatus::Open)
        ->and($order->type)->toBe(OrderType::Order)
        ->and($order->rep_code)->toBe('ABC');
});

it('throws an exception loading nonexisting order number', function () {
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
    $client->orders()->findByOrderNumber('FAKE');
})->throws(NotFoundException::class);
