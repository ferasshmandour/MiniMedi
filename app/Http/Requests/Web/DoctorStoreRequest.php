<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DoctorStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $locales = ['en', 'ar'];

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'license_number' => 'required|string|unique:doctors',
            'phone' => 'nullable|string|max:20',
            'available_from' => 'nullable',
            'available_to' => 'nullable',
        ];

        // Add translatable field rules for each locale
        foreach ($locales as $locale) {
            $rules["specialization.{$locale}"] = 'nullable|string|max:255';
            $rules["department.{$locale}"] = 'nullable|string|max:100';
            $rules["bio.{$locale}"] = 'nullable|string';
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        $messages = [
            'name.required' => __('validation.required'),
            'email.required' => __('validation.required'),
            'email.email' => __('validation.email'),
            'email.unique' => __('validation.unique'),
            'password.required' => __('validation.required'),
            'password.min' => __('validation.min'),
            'password.confirmed' => __('validation.confirmed'),
            'license_number.required' => __('validation.required'),
            'license_number.unique' => __('validation.unique'),
        ];

        return $messages;
    }
}
