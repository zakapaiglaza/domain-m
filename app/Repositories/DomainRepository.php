<?php

namespace App\Repositories;

use App\Interfaces\DomainRepositoryInterface;
use App\Models\Domain;
use Illuminate\Database\Eloquent\Collection;

class DomainRepository implements DomainRepositoryInterface
{
    public function __construct(protected Domain $model) {}

    public function create(array $data): Domain
    {
        return $this->model->create($data);
    }

    public function update(Domain $domain, array $data): bool
    {
        return $domain->update($data);
    }

    public function delete(Domain $domain): bool
    {
        return $domain->delete();
    }

    public function find(int $id): ?Domain
    {
        return $this->model->find($id);
    }

    public function getAll(): Collection
    {
        return $this->model->get();
    }

    public function getByUser(int $userId): Collection
    {
        return $this->model->where('user_id', $userId)->get();
    }

    public function findByUserAndId(int $userId, int $id): ?Domain
    {
        return $this->model->where('user_id', $userId)->find($id);
    }
}
