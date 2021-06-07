<?php

namespace App\Http\Requests\API\Client;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class ResturantStoreInfoRequest extends FormRequest
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
            'services' => 'required',
            'maximum_delivery_distance' => 'required',
            'neighborhood_delivery_price' => 'required',
            'outside_neighborhood_delivery_price' => 'required',
            'minimum_purchase_free_delivery_in_neighborhood' => 'required',
            'minimum_purchase_free_delivery_outside_neighborhood' => 'required',
            'open_time' => 'required',
            'close_time' => 'required',
            'accepted_payment_methods' => 'required',
            'loyalty_points' => 'required',
            'customer_earn_points' => 'required',
            'categories' => 'required',
            'latitude' => 'required',
            'longetitue' => 'required',
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
            'services.required' => 'يجب أختيار خدمات المطعم',
            'maximum_delivery_distance.required' => 'أقصى مسافة لخدمة التوصيل مطلوب',
            'neighborhood_delivery_price.required' => 'سعر التوصيل في نطاق الحي مطلوب',
            'outside_neighborhood_delivery_price.required' => 'سعر التوصيل خارج نطاق الحي مطلوب',
            'minimum_purchase_free_delivery_in_neighborhood.required' => 'في نطاق الحي مطلوب',
            'minimum_purchase_free_delivery_outside_neighborhood.required' => 'خارج نطاق الحي مطلوب',
            'open_time.required' => 'زمن بدء العمل مطلوب',
            'close_time.required' => 'زمن انتهاء العمل مطلوب',
            'accepted_payment_methods.required' => 'يجب اختيار خدمات الدفع',
            'loyalty_points.required' => 'الاشتراك في برنامج نقاط الولاء للعملاء مطلوب',
            'customer_earn_points.required' => 'عدد النقاط مطلوب',
            'categories.required' => 'أختيار تصنيف المطعم',
            'latitude.required' => 'خطوط الطول مطلوبة',
            'longetitue.required' => 'خطوط العرض مطلوبة',
        ];
    }
}
