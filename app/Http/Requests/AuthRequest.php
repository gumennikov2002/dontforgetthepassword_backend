<?php

namespace App\Http\Requests;

class AuthRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'email'       => 'required',
            'password'    => 'required',
            'device_name' => 'required'
        ];
    }
}
