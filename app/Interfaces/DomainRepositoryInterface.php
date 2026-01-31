<?php

namespace App\Interfaces;

use App\Models\Domain;
use Illuminate\Database\Eloquent\Collection;

interface DomainRepositoryInterface
{
    public function create(array $data): Domain;

    public function update(Domain $domain, array $data): bool;

    public function delete(Domain $domain): bool;

    public function find(int $id): ?Domain;

    public function getAll(): Collection;

    public function getByUser(int $userId): Collection;

    public function findByUserAndId(int $userId, int $id): ?Domain;
}
