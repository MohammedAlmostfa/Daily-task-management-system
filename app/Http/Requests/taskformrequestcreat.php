<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class taskformrequestcreat extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        return redirect()->back()->with('error', $validator->errors()->first());
    }

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
            'Task_name' => 'required|string|max:255|min:5',
            'Description' => 'required|string',
     'Due_time' => 'required'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'Task_name' => 'task name',
            'Description' => 'task description',
            'Due_time' => 'due time',
        ];


    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'Task_name.required' => 'The :attribute is required and must be at least 5 characters.',
            'Task_name.min' => 'The :attribute must be at least :min characters.',
            'Description.required' => 'The :attribute is required.',
            'Due_time.required' => 'The :attribute is required and must be a valid date.',
            'Due_time.after' => 'The :attribute must be a date after now.'
        ];
    }
}
