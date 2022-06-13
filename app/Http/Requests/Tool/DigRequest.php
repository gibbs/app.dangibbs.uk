<?php

namespace App\Http\Requests\Tool;

use Illuminate\Foundation\Http\FormRequest;

class DigRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Nameserver list
        $nameservers = ['cloudflare', 'google', 'quad9', 'opendns', 'comodo'];

        // DNS lookup types
        $types = [
            'a', 'aaaa', 'any', 'caa', 'cname', 'dnskey', 'ds', 'mx', 'ns',
            'ptr', 'soa', 'srv', 'tlsa', 'tsig', 'txt',
        ];

       return [
            'name'  => ['required', 'string', 'between: 1,258'],
            'nameserver' => ['required', 'string', 'in:' . implode(',', $nameservers)],
            'types' => ['array', 'in:' . implode(',', $types)],
        ];
    }
}
