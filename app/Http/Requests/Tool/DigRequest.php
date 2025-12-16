<?php

namespace App\Http\Requests\Tool;

use Illuminate\Foundation\Http\FormRequest;

class DigRequest extends FormRequest
{
    /**
     * Valid nameservers
     *
     * @var array
     */
    private $nameservers = [
        'cloudflare',
        'google',
        'quad9',
        'opendns',
        'comodo',
    ];

    /**
     * Valid DNS types
     *
     * @var array
     */
    private $types = [
        'a',
        'aaaa',
        'any',
        'caa',
        'cname',
        'dnskey',
        'ds',
        'mx',
        'ns',
        'ptr',
        'soa',
        'srv',
        'tlsa',
        'tsig',
        'txt',
    ];

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Nameserver list
        $nameservers = implode(',', $this->nameservers);

        // DNS lookup types
        $types = implode(',', $this->types);

       return [
            'name'  => ['required', 'string', 'between: 1,258'],
            'nameserver' => ['required', 'string', 'in:' . $nameservers],
            'types' => ['array', 'in:' . $types],
        ];
    }
}
