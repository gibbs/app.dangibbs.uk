<?php

namespace App\Http\Requests\Tool;

use Illuminate\Foundation\Http\FormRequest;

class MkpasswdRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'input'  => ['required', 'alpha_num', 'string', 'between: 1,64'],
            'method' => ['required', 'string', 'in:sha512crypt,sha256crypt,scrypt,md5crypt'],
            'rounds' => ['integer', 'numeric', 'between:0,1000000'],
        ];

        // sha512/sha256
        if (in_array((string) $this->request->get('method'), ['sha512crypt', 'sha256crypt'])) {
            $rules += [
                'salt' => ['nullable', 'alpha_num', 'between:8,16'],
            ];
        }

        // md5
        if ((string) $this->request->get('method') === 'md5crypt') {
            $rules += [
                'salt' => ['nullable', 'alpha_num', 'size:8'],
            ];
        }

        // scrypt
        if ((string) $this->request->get('method') === 'scrypt') {
            $rules += [
                'salt' => ['nullable', 'prohibited'],
            ];

            $rules['rounds'] = ['nullable', 'in:0,6,7,8,9,10,11'];
        }

        return $rules;
    }
}
