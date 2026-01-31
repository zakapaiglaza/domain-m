<?php

namespace Api\Http\Requests;

use App\Models\Domain;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DomainRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $domainId = $this->route('domain')?->id;

        return [
            'name' => ['required', 'url', Rule::unique('domains', 'name')->ignore($domainId)],
            'interval_minutes' => 'required|integer|min:1|max:1440',
            'timeout_seconds' => 'required|integer|min:1|max:60',
            'method' => 'required|in:' . implode(',', Domain::ALLOWED_METHODS),
        ];
    }
}
