<?php

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
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
    $client = new OrderTrackClient('test', handler: HandlerStack::create($mock));
    $account = $client->getAccount();
    expect($account)->toBeInstanceOf(User::class);
    expect($account->id)->toBe(1);
    expect($account->name)->toBe('John Doe');
    expect($account->email)->toBe('john@example.com');
    expect($account->admin)->toBe(false);
    expect($account->page_size)->toBe(15);
    expect($account->email_sample_orders)->toBe(false);
    expect($account->allow_direct_sample_types)->toBe(false);
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
    $client = new OrderTrackClient('test', handler: HandlerStack::create($mock));
    $users = $client->users()->list();
    expect($users)->toBeArray();
    expect($users)->toHaveCount(1);
    expect($users[0])->toBeInstanceOf(User::class);
    expect($users[0]->id)->toBe(1);
    expect($users[0]->name)->toBe('John Doe');
    expect($users[0]->email)->toBe('john@example.com');
    expect($users[0]->admin)->toBe(false);
    expect($users[0]->page_size)->toBe(15);
    expect($users[0]->email_sample_orders)->toBe(false);
    expect($users[0]->allow_direct_sample_types)->toBe(false);
});
