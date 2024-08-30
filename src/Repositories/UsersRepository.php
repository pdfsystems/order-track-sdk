<?php

namespace Pdfsystems\OrderTrackSdk\Repositories;

use DateTimeInterface;
use GuzzleHttp\Exception\GuzzleException;
use Pdfsystems\OrderTrackSdk\Dtos\Company;
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

    /**
     * @throws UnknownProperties
     * @throws GuzzleException
     */
    public function create(Company|int $company, User $user): User
    {
        $userData = array_merge(
            ['team_id' => is_int($company) ? $company : $company->id],
            $user->toArray()
        );
        $userData = array_filter($userData);

        return new User(
            $this->client->postJson(
                "api/users",
                $userData
            )
        );
    }
}
