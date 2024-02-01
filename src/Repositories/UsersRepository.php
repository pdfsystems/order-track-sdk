<?php

namespace Pdfsystems\OrderTrackSdk\Repositories;

use DateTimeInterface;
use GuzzleHttp\Exception\GuzzleException;
use Pdfsystems\OrderTrackSdk\Dtos\User;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class UsersRepository extends Repository
{
    /**
     * @return User[]
     * @throws GuzzleException
     * @throws UnknownProperties
     */
    public function list(bool $includeReps = false, DateTimeInterface $lastUpdated = null): array
    {
        $query = [
            'include_reps' => $includeReps,
        ];

        if (! is_null($lastUpdated)) {
            $query['updated_at'] = $lastUpdated->format('Y-m-d H:i:s');
        }

        return $this->client->getDtoArray('api/users', User::class, $query);
    }
}
