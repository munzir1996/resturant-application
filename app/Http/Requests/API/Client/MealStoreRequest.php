<?php

namespace App\Http\Requests\API\Client;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class MealStoreRequest extends FormRequest
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
            'name' => 'required',
            'classification_id' => 'required',
            'price' => 'required',
            'detail' => 'required',
            'calorie' => 'required',
            'size' => 'required',
            'tax' => 'required',
            'points' => 'required',
            'meal_addons' => 'sometimes',
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
            'classification_id.required' => 'التصنيف مطلوب',
            'price.required' => 'السعر مطلوب',
            'detail.required' => 'التفاصيل مطلوبة',
            'calorie.required' => 'الكالوري المطلوب',
            'size.required' => 'الحجم مطلوب',
            'tax.required' => 'الضريبة مطلوب',
            'points.required' => 'النقاط مطلوب',
        ];
    }

}


