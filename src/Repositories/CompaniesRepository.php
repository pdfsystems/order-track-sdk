<?php

namespace Pdfsystems\OrderTrackSdk\Repositories;

use Pdfsystems\OrderTrackSdk\Dtos\Company;

class CompaniesRepository extends Repository
{
    public function create(Company $company): Company
    {
        return $this->client->postDto('api/teams', $company);
    }
}
