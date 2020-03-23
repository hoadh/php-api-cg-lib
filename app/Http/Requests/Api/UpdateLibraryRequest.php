<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateLibraryRequest extends FormRequest
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
            'address' => 'required',
            'phone'   =>  "required|unique:users,phone,$this->id,id|regex:/^(0)\\d{9,10}$/",
            'desc'  => 'required',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:5120',
            'manager' => 'required',
            'manager_phone' => 'required|regex:/^(0)\\d{9,10}$/',
            'manager_address'   => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('language.name_library_required'),
            'address.required' => __('language.address_library_required'),
            'phone.required' => __('language.phone_required'),
            'phone.regex' => __('language.phone_not_format'),
            'desc.required' => __('language.desc_required'),
            'image.required' => __('language.image_library_required'),
            'image.image' => __('language.image_library_not_format'),
            'image.mimes' => __('language.image_library_mimes'),
            'image.max' => __('language.image_library_max'),
            'manager.required' => __('language.manager_name_required'),
            'manager_phone.required' => __('language.manager_phone_required'),
            'manager_phone.regex' => __('language.phone_not_format'),
            'manager_address.required' => __('language.manager_address_required')
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => 'error',
            'message' => $validator->errors()->all()], 422));
    }
}
