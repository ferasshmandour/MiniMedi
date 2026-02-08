<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class MedicalNoteStoreRequest extends FormRequest
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
            'appointment_id' => 'required|exists:appointments,id',
            'vital_signs' => 'nullable|string',
        ];

        // Add translatable field rules for each locale
        foreach ($locales as $locale) {
            $rules["diagnosis.{$locale}"] = 'nullable|string';
            $rules["prescription.{$locale}"] = 'nullable|string';
            $rules["treatment_plan.{$locale}"] = 'nullable|string';
            $rules["symptoms.{$locale}"] = 'nullable|string';
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'appointment_id.required' => __('validation.required'),
            'appointment_id.exists' => __('validation.exists'),
        ];
    }
}
