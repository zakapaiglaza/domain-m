<?php

namespace Api\Http\Controllers;

use Api\Http\Requests\DomainRequest;
use Api\Http\Resources\DomainResource;
use App\Services\DomainService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Api\Http\Resources\CheckResource;

class DomainController
{
    public function __construct(protected DomainService $service) {}

    public function index(): JsonResponse
    {
        $domains = $this->service->getByUser();

        return response()->json(DomainResource::collection($domains));
    }

    public function store(DomainRequest $request): JsonResponse
    {
        $domain = $this->service->create($request->validated());

        return response()->json(new DomainResource($domain), Response::HTTP_CREATED);
    }

    public function show(int $id): JsonResponse
    {
        $domain = $this->service->findById($id);

        if (!$domain) {
            return response()->json(['message' => 'Домен не найден или не принадлежит вам'], 404);
        }

        return response()->json(new DomainResource($domain));
    }

    public function update(DomainRequest $request, int $id): JsonResponse
    {
        $domain = $this->service->update($id, $request->validated());

        if (!$domain) {
            return response()->json(['message' => 'Домен не найден или не принадлежит вам'], 404);
        }

        return response()->json(new DomainResource($domain));
    }

    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->service->delete($id);

        if (!$deleted) {
            return response()->json(['message' => 'Домен не найден или не принадлежит вам'], 404);
        }

        return response()->json(['message' => 'Домен удалён']);
    }

    public function checks(int $domainId): JsonResponse
    {
        $domain = $this->service->findById($domainId);

        if (!$domain) {
            return response()->json(['message' => 'Домен не найден или не принадлежит вам'], 404);
        }

        $checks = $domain->checks()->latest()->get();

        return response()->json(CheckResource::collection($checks));
    }
}
