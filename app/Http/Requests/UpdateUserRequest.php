<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function rules(): array {

        return [

            'name' => 'required|string|max:255',

            'email' => 'required|email|unique:users,email|max:255',

            'role' => 'required|string|max:255',

            'password' => [

                'required',

                'string',

                Password::min(8)->mixedCase()->numbers()->symbols()->uncompromised(),

                'confirmed',

            ]

        ];
    }
}    