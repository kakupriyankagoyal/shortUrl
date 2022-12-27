<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class ShortUrlRequest extends FormRequest
{
    

    public function __construct()
    {
        $this->validation = config('validation');
    }
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
            'url' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'url.required' => $this->validation['requiredFieldValidationMessages']['url'],
        ];
     }

    public function failedValidation(Validator $validator)
    {
       throw new HttpResponseException(response()->json([
         'success'   => false,
         'message'   => 'Bad Requests.',
         'error'     => $validator->errors(),
       ],400));


    }
}
