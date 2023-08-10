<?php

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Pdfsystems\OrderTrackSdk\Dtos\Pagination\ProductList;
use Pdfsystems\OrderTrackSdk\OrderTrackClient;
use Pdfsystems\OrderTrackSdk\Repositories\ProductsRepository;

it('can create product repositories', function () {
    $client = new OrderTrackClient('test', 'https://example.com');
    expect($client->products())->toBeInstanceOf(ProductsRepository::class);
});

it('can search for products', function () {
    $data = [
        'current_page' => 1,
        'data' => [
            [
                'id' => 1,
                'item_number' => '1000-01',
                'style_name' => 'Test Product',
                'color_name' => 'Red',
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
    $client = new OrderTrackClient('test', 'https://example.com', HandlerStack::create($mock));
    $products = $client->products()->search(1);
    expect($products)->toBeInstanceOf(ProductList::class);
    expect($products->data)->toHaveCount(1);
    expect($products->data[0]->id)->toBe(1);
    expect($products->data[0]->style_name)->toBe('Test Product');
    expect($products->data[0]->color_name)->toBe('Red');
});
