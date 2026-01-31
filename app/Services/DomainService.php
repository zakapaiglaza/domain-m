<?php

namespace App\Services;

use App\Interfaces\DomainRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use App\Models\Domain;

class DomainService
{
    public function __construct(protected DomainRepositoryInterface $repository) {}


    public function create(array $data): Domain
    {
        $data['user_id'] = Auth::id();

        return $this->repository->create($data);
    }

    public function update(int $id, array $data): ?Domain
    {
        $domain = $this->repository->findByUserAndId(Auth::id(), $id);

        if (!$domain) {
            return null;
        }

        $this->repository->update($domain, $data);

        return $domain->fresh();
    }

    public function delete(int $id): bool
    {
        $domain = $this->repository->findByUserAndId(Auth::id(), $id);

        if (!$domain) {
            return false;
        }

        return $this->repository->delete($domain);
    }

    public function getByUser(): Collection
    {
        return $this->repository->getByUser(Auth::id());
    }

    public function findById(int $id): ?Domain
    {
        return $this->repository->findByUserAndId(Auth::id(), $id);
    }
}
