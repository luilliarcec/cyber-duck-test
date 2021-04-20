<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'company_id' => 'required|integer|exists:companies,id',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|max:255'
        ];
    }
}
