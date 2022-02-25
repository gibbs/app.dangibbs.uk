<?php

namespace App\Http\Requests\Tool;

use Illuminate\Foundation\Http\FormRequest;

class PwgenRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'no-numerals'   => ['nullable', 'boolean'],
            'no-capitalize' => ['nullable', 'boolean'],
            'ambiguous'     => ['nullable', 'boolean'],
            'capitalize'    => ['nullable', 'boolean'],
            'num-passwords' => ['required', 'integer', 'between:1,100'],
            'numerals'      => ['nullable', 'boolean'],
            'remove-chars'  => ['nullable', 'string', 'between:1, 65'],
            'secure'        => ['nullable', 'boolean'],
            'no-vowels'     => ['nullable', 'boolean'],
            'symbols'       => ['nullable', 'boolean'],
            'length'        => ['integer', 'between:1,8192'],
        ];
    }
}
