<?php

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Pdfsystems\OrderTrackSdk\Dtos\Pagination\SampleOrderList;
use Pdfsystems\OrderTrackSdk\Dtos\SampleOrder;
use Pdfsystems\OrderTrackSdk\OrderTrackClient;
use Pdfsystems\OrderTrackSdk\Repositories\SampleOrdersRepository;

it('can create sample order repositories', function () {
    $client = new OrderTrackClient('test');
    expect($client->sampleOrders())->toBeInstanceOf(SampleOrdersRepository::class);
});

it('can search for sample orders', function () {
    $data = [
        'current_page' => 1,
        'data' => [
            [
                'id' => 1,
                'order_number' => '123456',
                'items' => [
                ],
                'sample_usage_type_id' => 1,
                'sample_order_source_id' => 1,
                'usage_type' => [
                    'id' => 1,
                    'name' => 'Project',
                ],
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
    $client = new OrderTrackClient('test', handler: HandlerStack::create($mock));
    $products = $client->sampleOrders()->search();
    expect($products)->toBeInstanceOf(SampleOrderList::class)
        ->and($products->data)->toHaveCount(1);
});

it('can create sample orders', function () {
    $data = [
        'items' => [
        ],
        'sample_usage_type_id' => 1,
        'sample_order_source_id' => 1,
    ];
    $mock = new MockHandler([
        new Response(200, ['content-type' => 'application/json'], json_encode($data)),
    ]);
    $client = new OrderTrackClient('test', handler: HandlerStack::create($mock));
    $products = $client->sampleOrders()->create(new SampleOrder($data));
    expect($products)->toBeInstanceOf(SampleOrder::class);
});
