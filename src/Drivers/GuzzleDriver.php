<?php

namespace Pdfsystems\OrderTrackSdk\Drivers;

use GuzzleHttp\HandlerStack;

class GuzzleDriver extends \Rpungello\SdkClient\Drivers\GuzzleDriver
{
    use OrderTrackDriver;

    public function __construct(private readonly string $authToken, private readonly ?int $teamId = null, string $baseUri = 'https://www.order-track.com', HandlerStack $handler = null)
    {
        parent::__construct($baseUri, $handler, static::getUserAgent());
    }

    protected function getGuzzleClientConfig(): array
    {
        $config = parent::getGuzzleClientConfig();
        $config['headers']['authorization'] = "Bearer $this->authToken";

        if (! empty($this->teamId)) {
            $config['headers']['x-team-id'] = $this->teamId;
        }

        return $config;
    }
}
