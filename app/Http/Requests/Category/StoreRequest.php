<?php

namespace App\Http\Requests\Category;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException; 

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|min:5|max:500',
            'slug' => 'required|min:3|max:500|unique:posts',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        if($this->expectsJson()){
            $response = new Response($validator->errors(),422);
            throw new ValidationException($validator, $response());
        }

    }
}
