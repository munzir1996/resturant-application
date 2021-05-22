<?php

namespace App\Http\Requests\API\Client;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class ResturantStoreRequest extends FormRequest
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
            'commercial_registration_no' => 'required',
            'open_time' => 'required',
            'close_time' => 'required',
            'delivery' => 'required',
            'category_id' => 'required',
            'latitude' => 'required',
            'longetitue' => 'required',
            'country_id' => 'required',
            'city_id' => 'required',
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
            'name.required' => 'الأسم مطلوب',
            'name_ar.required' => 'أسم المطعم مطلوب',
            'commercial_registration_no.required' => 'رقم السجل التجاري مطلوب',
            'open_time.required' => 'زمن الأفتتاح مطلوب',
            'close_time.required' => 'زمن الأغلاق مطلوب',
            'delivery.required' => 'أختيار التوصيل مطلوب',
            'category_id.required' => 'التصنيف مطلوب',
            'latitude.required' => 'خط الطول مطلوب',
            'longetitue.required' => 'خط العرض مطلوب',
            'country_id.required' => 'الدولة مطلوبة',
            'city_id.required' => 'المدينة مطلوبة',
            'bank_name.required' => 'أسم البنك مطلوب',
            'iban.required' => 'رقم الأيبان مطلوب',
        ];
    }

}



