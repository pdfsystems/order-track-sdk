<?php

namespace Pdfsystems\OrderTrackSdk\Drivers;

use Composer\InstalledVersions;
use OutOfBoundsException;

trait OrderTrackDriver
{
    protected static function getUserAgent(): string
    {
        return 'Order-Track SDK/' . static::getVersion();
    }

    private static function getVersion(): string
    {
        try {
            return InstalledVersions::getVersion('pdfsystems/order-track-sdk');
        } catch (OutOfBoundsException) {
            return 'dev';
        }
    }
}
