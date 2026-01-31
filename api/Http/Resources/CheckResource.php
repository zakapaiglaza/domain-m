<?php

namespace Api\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CheckResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'checked_at' => $this->checked_at->toDateTimeString(),
            'success' => $this->success,
            'status_code' => $this->status_code,
            'response_time_ms' => $this->response_time_ms,
            'error_message' => $this->error_message,
        ];
    }
}
