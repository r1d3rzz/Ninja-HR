<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEmployee extends FormRequest
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
            "employee_id" => ["required", Rule::unique("users", "employee_id")],
            "name" => ["required", "min:3"],
            "phone" => ["required", Rule::unique("users", "phone")],
            "email" => ["required", "email", Rule::unique("users", "email")],
            "nrc_number" => ["required", Rule::unique("users", "nrc_number")],
            "gender" => ["required"],
            "birthday" => ["required"],
            "address" => ["required"],
            "department_id" => ["required", Rule::exists("departments", "id")],
            "date_of_join" => ["required"],
            "is_present" => ["required"],
            "password" => ["required", "min:8"],
        ];
    }
}
