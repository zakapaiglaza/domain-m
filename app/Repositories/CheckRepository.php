<?php

namespace App\Repositories;

use App\Interfaces\CheckRepositoryInterface;
use App\Models\Check;
use App\Models\Domain;

class CheckRepository implements CheckRepositoryInterface
{
    public function __construct(protected Check $model) {}

    public function createForDomain(Domain $domain, array $data): Check
    {
        $data['domain_id'] = $domain->id;
        $data['checked_at'] = now();

        return $this->model->create($data);
    }

    public function getLatestForDomain(Domain $domain): ?Check
    {
        return $this->model->where('domain_id', $domain->id)
            ->latest('checked_at')
            ->first();
    }
}
