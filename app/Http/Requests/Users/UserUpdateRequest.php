<?php

namespace App\Http\Requests\Users;

use App\Models\User;
use App\Rules\VerifiedUserRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

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
            'email' => [
                'sometimes', 
                'required', 
                'email', 
                Rule::unique('users')->ignore($this->user)
            ],
            'password'  => 'sometimes|required|min:6|confirmed',
            'admin'     => [
                'sometimes',
                'required',
                'in:' . User::ADMIN_USER . ',' . User::REGULAR_USER,
                new VerifiedUserRule($this->user), // Rule to check if user is allowed to change admin field means whether the user is verified or not
            ],
        ];
    }
}
