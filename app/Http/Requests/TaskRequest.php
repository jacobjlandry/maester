<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class TaskRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'integer|required',
            'title' => 'string|required',
            'description' => 'string',
            'parent_id' => 'string|nullable',
            'completed' => 'boolean',
            'completed_at' => "date|nullable",
            'type' => 'string|nullable',
            'hideOnComplete' => 'boolean|nullable',
        ];
    }

    /**
     * Handle validation errors response
     */
    protected function failedValidation(Validator $validator)
    {
        $response = [
            "errors" => $validator->errors()
        ];

        throw new HttpResponseException(response()->json($response, 400));
    }
}
