<?php

namespace App\Listeners;

use App\Events\DomainChecked;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendNotificationOnFailure
{
    public function handle(DomainChecked $event): void
    {
        if (!$event->check->success) {
            $logData = [
                'domain' => $event->domain->name,
                'user_id' => $event->domain->user_id,
                'error'  => $event->check->error_message,
                'status_code' => $event->check->status_code,
                'response_time_ms' => $event->check->response_time_ms,
                'checked_at' => $event->check->checked_at->toDateTimeString(),
            ];

            Log::channel('domain-failures')->warning('Проверка домена провалилась', $logData);
        }
    }
}
