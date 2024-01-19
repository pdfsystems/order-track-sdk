<?php

namespace Pdfsystems\OrderTrackSdk\Repositories;

use GuzzleHttp\Exception\GuzzleException;
use Pdfsystems\OrderTrackSdk\Dtos\User;

class UsersRepository extends Repository
{
    /**
     * @return User[]
     * @throws GuzzleException
     */
    public function list(bool $includeReps = false): array
    {
        return $this->client->getDtoArray('api/users', User::class, [
            'include_reps' => $includeReps,
        ]);
    }
}
