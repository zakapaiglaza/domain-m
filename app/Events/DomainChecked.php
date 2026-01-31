<?php

namespace App\Events;

use App\Models\Check;
use App\Models\Domain;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DomainChecked
{
    use Dispatchable, SerializesModels;

    public function __construct(public Domain $domain,public Check $check) {}
}
