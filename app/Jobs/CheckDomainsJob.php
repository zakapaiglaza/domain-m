<?php

namespace App\Jobs;

use App\Interfaces\DomainRepositoryInterface;
use App\Services\CheckService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Models\Domain;

class CheckDomainsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        $domains = Domain::where('active', true)->get();

        foreach ($domains as $domain) {
            $start = microtime(true);
            $status = 'DOWN';
            $httpCode = null;
            $error = null;

            try {
                $options = [
                    "http" => [
                        "method" => $domain->method,
                        "timeout" => $domain->timeout_seconds,
                        "ignore_errors" => true,
                    ],
                ];

                $context = stream_context_create($options);
                $response = @file_get_contents($domain->url, false, $context);

                if (isset($http_response_header[0])) {
                    preg_match('/HTTP\/\d+\.\d+\s+(\d+)/', $http_response_header[0], $matches);
                    $httpCode = $matches[1] ?? null;
                }

                $status = $response !== false ? 'UP' : 'DOWN';
            } catch (\Throwable $e) {
                $error = $e->getMessage();
            }

            $duration = round(microtime(true) - $start, 2);

            Log::info("Domain check: {$domain->url}", [
                'status' => $status,
                'http_code' => $httpCode,
                'response_time_sec' => $duration,
                'error' => $error,
            ]);

            $domain->update(['last_checked_at' => now()]);
        }
    }
}
