<?php

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Pdfsystems\OrderTrackSdk\Dtos\Pagination\ProductList;
use Pdfsystems\OrderTrackSdk\Dtos\Product;
use Pdfsystems\OrderTrackSdk\Exceptions\NotFoundException;
use Pdfsystems\OrderTrackSdk\OrderTrackClient;
use Pdfsystems\OrderTrackSdk\Repositories\ProductsRepository;

it('can create product repositories', function () {
    $client = new OrderTrackClient('test');
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
    $client = new OrderTrackClient('test', handler: HandlerStack::create($mock));
    $products = $client->products()->search();
    expect($products)->toBeInstanceOf(ProductList::class)
        ->and($products->data)->toHaveCount(1)
        ->and($products->data[0]->id)->toBe(1)
        ->and($products->data[0]->style_name)->toBe('Test Product')
        ->and($products->data[0]->color_name)->toBe('Red');
});

it('can calculate shipping', function () {
    $data = [
        [
            'serviceName' => 'Ground',
            'components' => [
                [
                    'type' => 'base',
                    'amount' => 10,
                ],
            ],
            'rate' => 10.00,
        ],
        [
            'serviceName' => 'Express',
            'components' => [
                [
                    'type' => 'base',
                    'amount' => 20,
                ],
            ],
            'rate' => 20.00,
        ],
    ];
    $product = new Product([
        'id' => 1,
        'item_number' => '1000-01',
        'style_name' => 'Test Product',
        'color_name' => 'Red',
    ]);

    $mock = new MockHandler([
        new Response(200, ['content-type' => 'application/json'], json_encode($data)),
    ]);
    $client = new OrderTrackClient('test', handler: HandlerStack::create($mock));
    $shipping = $client->products()->calculateShipping($product, '12345');
    expect($shipping)->toBeArray()
        ->and($shipping)->toHaveCount(2)
        ->and(array_keys($shipping))->toBe(['Ground', 'Express'])
        ->and(array_values($shipping))->toBe([10, 20]);
});

it('can calculate shipping from IDs', function () {
    $productData = [
        'id' => 1,
        'item_number' => '1000-01',
        'style_name' => 'Test Product',
        'color_name' => 'Red',
    ];
    $shippingData = [
        [
            'serviceName' => 'Ground',
            'components' => [
                [
                    'type' => 'base',
                    'amount' => 10,
                ],
            ],
            'rate' => 10.00,
        ],
        [
            'serviceName' => 'Express',
            'components' => [
                [
                    'type' => 'base',
                    'amount' => 20,
                ],
            ],
            'rate' => 20.00,
        ],
    ];

    $mock = new MockHandler([
        new Response(200, ['content-type' => 'application/json'], json_encode($productData)),
        new Response(200, ['content-type' => 'application/json'], json_encode($shippingData)),
    ]);
    $client = new OrderTrackClient('test', handler: HandlerStack::create($mock));
    $shipping = $client->products()->calculateShipping(1, '12345');
    expect($shipping)->toBeArray()
        ->and($shipping)->toHaveCount(2)
        ->and(array_keys($shipping))->toBe(['Ground', 'Express'])
        ->and(array_values($shipping))->toBe([10, 20]);
});

it('can load individual products by item number', function () {
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
    $client = new OrderTrackClient('test', handler: HandlerStack::create($mock));
    $product = $client->products()->findByItemNumber('1000-01');
    expect($product)->toBeInstanceOf(Product::class)
        ->and($product->id)->toBe(1)
        ->and($product->style_name)->toBe('Test Product')
        ->and($product->color_name)->toBe('Red');
});

it('throws an exception loading nonexisting item number', function () {
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
    $client = new OrderTrackClient('test', handler: HandlerStack::create($mock));
    $client->products()->findByItemNumber('1000-01F');
})->throws(NotFoundException::class);
