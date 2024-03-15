<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class GetTableRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'table_id' => 'required|int',
            'user_id' => 'required|int',
        ];
    }
        /**
     * @param Validator $validator
     *
     * @return void
     */
    public function failedValidation(Validator $validator): void
    {
        abort(418, $validator->errors());
    }

    /**
     * Set required fields to be validated
     * @return void
     */
    // public function prepareForValidation(): void
    // {
    //     if (!array_key_exists('itemsPerPage', $this->all())) {
    //         $this->merge(['itemsPerPage' => 10]);
    //     }      
    // }
}
