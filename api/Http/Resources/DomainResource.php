<?php

namespace Api\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DomainResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'interval_minutes' => $this->interval_minutes,
            'timeout_seconds' => $this->timeout_seconds,
            'method' => $this->method,
            'last_checked_at' => $this->last_checked_at?->toDateTimeString(),
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
