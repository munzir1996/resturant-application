<?php

namespace App\Http\Requests\API\Client;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class ResturantStoreBasicInfoRequest extends FormRequest
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
     * If validator fails return the exception in json form
     * @param Validator $validator
     * @return array
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['errors' => $validator->errors()], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name_ar' => 'required',
            'name_en' => 'sometimes',
            'manager_name' => 'required',
            'manager_phone' => 'required',
            'email' => 'required',
            'commercial_registration_no' => 'required',
            'bank_name' => 'required',
            'iban' => 'required',
        ];
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name_ar.required' => 'أسم المطعم مطلوب',
            'manager_name.required' => 'أسم المدير المسؤل مطلوب',
            'manager_phone.required' => 'رقم جوال المدير المسؤل مطلوب',
            'email.required' => 'البريد الألكتروني مطلوب',
            'commercial_registration_no.required' => 'رقم السجل التجاري مطلوب',
            'bank_name.required' => 'أسم البنك مطلوب',
            'iban.required' => 'رقم الأيبان مطلوب',
        ];
    }
}
