<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAccountRequest extends FormRequest
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
        return [
            'goal' => ['required'],
            'age' => ['required', 'integer'],
            'gender' => ['required', 'in:Male,Female'],
            'height' => ['required', 'numeric'],
            'weight' => ['required', 'integer'],
            'activity' => ['required', 'numeric'],
        ];
    }
}