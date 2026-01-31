<?php

namespace App\Services;

use App\Interfaces\CheckRepositoryInterface;
use App\Interfaces\DomainRepositoryInterface;
use App\Models\Domain;
use App\Models\Check;
use App\Events\DomainChecked;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use Throwable;

class CheckService
{
    public function __construct(
        protected CheckRepositoryInterface $checkRepository,
        protected DomainRepositoryInterface $domainRepository
    ) {}

    public function check(Domain $domain): Check
    {
        $start = microtime(true);

        $result = [
            'success'          => false,
            'status_code'      => null,
            'response_time_ms' => null,
            'error_message'    => null,
        ];

        try {
            $client = new Client([
                'timeout' => $domain->timeout_seconds,
                'connect_timeout' => min(5, $domain->timeout_seconds),
                'allow_redirects' => true,
                'headers' => [
                    'User-Agent' => 'DomainMonitor/1.0 (+https://yourdomain.com)',
                ],
                'verify' => true,
            ]);

            $response = $client->request($domain->method, $domain->name);

            $result['success']     = true;
            $result['status_code'] = $response->getStatusCode();

        } catch (RequestException $e) {
            $result['error_message'] = $e->getMessage();
            if ($e->hasResponse()) {
                $result['status_code'] = $e->getResponse()->getStatusCode();
            }
        } catch (Throwable $e) {
            $result['error_message'] = $e->getMessage();
        }

        $result['response_time_ms'] = (int) round((microtime(true) - $start) * 1000);

        $check = $this->checkRepository->createForDomain($domain, $result);

        $this->domainRepository->update($domain, [
            'last_checked_at' => now(),
        ]);

        Log::info('Domain check completed', [
            'domain_id'        => $domain->id,
            'domain'           => $domain->name,
            'success'          => $result['success'],
            'status_code'      => $result['status_code'],
            'response_time_ms' => $result['response_time_ms'],
            'error_message'    => $result['error_message'],
        ]);

        event(new DomainChecked($domain, $check));

        return $check;
    }
}
