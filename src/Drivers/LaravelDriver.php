<?php

namespace Pdfsystems\OrderTrackSdk\Drivers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Client\PendingRequest;

class LaravelDriver extends \Rpungello\SdkClient\Drivers\LaravelDriver
{
    use OrderTrackDriver;

    public function __construct(Application $app, string $baseUri, private readonly string $authToken, private readonly ?int $teamId = null)
    {
        parent::__construct($app, $baseUri);
    }

    protected function pendingRequest(array $headers = []): PendingRequest
    {
        $request = parent::pendingRequest($headers)
            ->withUserAgent(static::getUserAgent())
            ->withToken($this->authToken);

        if (! empty($this->teamId)) {
            $request->withHeader('X-Team-Id', $this->teamId);
        }

        return $request;
    }
}
