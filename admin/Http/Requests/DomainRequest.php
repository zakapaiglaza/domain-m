<?php

namespace Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DomainRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $domainId = $this->route('domain')?->id;

        return [
            'url' => [
                'required',
                'string',
                'max:255',
                'regex:/^https?:\/\/[^\s$.?#].[^\s]*$/i',
                Rule::unique('domains', 'url')->ignore($domainId),
            ],
            'user_id' => 'required|exists:users,id',
            'interval_minutes' => 'required|integer|min:1|max:1440',
            'timeout_seconds' => 'required|integer|min:1|max:60',
            'method' => 'required|in:GET,HEAD',
            'active' => 'boolean',
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //
        ];
    }
}
