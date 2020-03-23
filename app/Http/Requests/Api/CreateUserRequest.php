<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateUserRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'phone' => 'required|regex:/^(0)\\d{9,10}$/|size:10',
            'username' => 'required|unique:users,username|alpha_dash',
            'password' => 'required|min:8',
            'library_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('language.name_user_required'),
            'phone.required' => __('language.phone_required'),
            'phone.regex' => __('language.phone_not_format'),
            'password.required' => __('language.password_required'),
            'password.min' => __('language.password_min'),
            'username.required' => __('language.username_required'),
            'username.unique' => __('language.username_unique'),
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => 'error',
            'message' => $validator->errors()->all()], 422));
    }
}
