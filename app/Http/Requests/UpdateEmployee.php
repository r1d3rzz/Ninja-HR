<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEmployee extends FormRequest
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
            "employee_id" => ["required", Rule::unique("users", "employee_id")->ignore($this->employee)],
            "name" => ["required", "min:3"],
            "phone" => ["required", Rule::unique("users", "phone")->ignore($this->employee)],
            "email" => ["required", "email", Rule::unique("users", "email")->ignore($this->employee)],
            "nrc_number" => ["required", Rule::unique("users", "nrc_number")->ignore($this->employee)],
            "gender" => ["required"],
            "birthday" => ["required"],
            "address" => ["required"],
            "department_id" => ["required", Rule::exists("departments", "id")],
            "date_of_join" => ["required"],
            "is_present" => ["required"],
        ];
    }
}
