<?php

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Pdfsystems\OrderTrackSdk\Drivers\GuzzleDriver;
use Pdfsystems\OrderTrackSdk\Dtos\User;
use Pdfsystems\OrderTrackSdk\OrderTrackClient;

it('can load user accounts', function () {
    $data = [
        'id' => 1,
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'admin' => false,
        'page_size' => 15,
        'email_sample_orders' => false,
        'allow_direct_sample_types' => false,
    ];
    $mock = new MockHandler([
        new Response(200, ['content-type' => 'application/json'], json_encode($data)),
    ]);
    $client = new OrderTrackClient(new GuzzleDriver('test', handler: HandlerStack::create($mock)));
    $account = $client->getAccount();
    expect($account)->toBeInstanceOf(User::class)
        ->and($account->id)->toBe(1)
        ->and($account->name)->toBe('John Doe')
        ->and($account->email)->toBe('john@example.com')
        ->and($account->admin)->toBe(false)
        ->and($account->page_size)->toBe(15)
        ->and($account->email_sample_orders)->toBe(false)
        ->and($account->allow_direct_sample_types)->toBe(false);
});

it('can list user accounts', function () {
    $data = [[
        'id' => 1,
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'admin' => false,
        'page_size' => 15,
        'email_sample_orders' => false,
        'allow_direct_sample_types' => false,
    ]];
    $mock = new MockHandler([
        new Response(200, ['content-type' => 'application/json'], json_encode($data)),
    ]);
    $client = new OrderTrackClient(new GuzzleDriver('test', handler: HandlerStack::create($mock)));
    $users = $client->users()->list();
    expect($users)->toBeArray()
        ->and($users)->toHaveCount(1)
        ->and($users[0])->toBeInstanceOf(User::class)
        ->and($users[0]->id)->toBe(1)
        ->and($users[0]->name)->toBe('John Doe')
        ->and($users[0]->email)->toBe('john@example.com')
        ->and($users[0]->admin)->toBe(false)
        ->and($users[0]->page_size)->toBe(15)
        ->and($users[0]->email_sample_orders)->toBe(false)
        ->and($users[0]->allow_direct_sample_types)->toBe(false);
});
