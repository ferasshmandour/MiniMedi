<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class AppointmentStoreRequest extends FormRequest
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
            'doctor_id' => 'required|exists:users,id',
            'appointment_date' => 'required|date|after:now',
        ];

        // Add translatable field rules for each locale
        foreach ($locales as $locale) {
            $rules["reason.{$locale}"] = 'nullable|string|max:1000';
            $rules["notes.{$locale}"] = 'nullable|string';
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        $messages = [
            'doctor_id.required' => __('validation.required'),
            'doctor_id.exists' => __('validation.exists'),
            'appointment_date.required' => __('validation.required'),
            'appointment_date.date' => __('validation.date'),
            'appointment_date.after' => __('validation.after'),
        ];

        // Add locale-specific messages
        foreach (['en', 'ar'] as $locale) {
            $messages["reason.{$locale}.max"] = __('validation.max', ['max' => 1000]);
        }

        return $messages;
    }
}
