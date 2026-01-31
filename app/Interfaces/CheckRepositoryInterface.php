<?php

namespace App\Interfaces;

use App\Models\Check;
use App\Models\Domain;

interface CheckRepositoryInterface
{
    public function createForDomain(Domain $domain, array $data): Check;

    public function getLatestForDomain(Domain $domain): ?Check;
}
