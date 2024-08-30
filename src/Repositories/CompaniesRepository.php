<?php

namespace Pdfsystems\OrderTrackSdk\Repositories;

use GuzzleHttp\Exception\GuzzleException;
use Pdfsystems\OrderTrackSdk\Dtos\Company;
use Pdfsystems\OrderTrackSdk\Dtos\Representation;

class CompaniesRepository extends Repository
{
    public function create(Company $company): Company
    {
        return $this->client->postDto('api/teams', $company);
    }

    public function find(int $id): Company
    {
        return $this->client->getDto("api/teams/$id", Company::class);
    }

    public function update(Company $company): Company
    {
        return $this->client->putDto("api/teams/$company->id", $company);
    }

    /**
     * @throws GuzzleException
     */
    public function representation(): array
    {
        return $this->client->getDtoArray('api/representation', Representation::class);
    }
}
