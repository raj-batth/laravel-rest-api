<?php

namespace App\Http\Requests\Users;

use App\Models\User;
use App\Rules\VerifiedUserRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserUpdateRequest extends FormRequest
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

    // protected function failedValidation(Validator $validator)
    // {
    //     throw new HttpResponseException(response()->json($validator->errors(), 422));
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email'     => 'required|email|unique:users',
            'password'  => 'required|min:6|confirmed',
            'admin'     => 'in:' . User::ADMIN_USER . ',' . User::REGULAR_USER,
            new VerifiedUserRule($this->user), // Rule to check if user is allowed to change admin field means whether the user is verified or not
        ];
    }
}
