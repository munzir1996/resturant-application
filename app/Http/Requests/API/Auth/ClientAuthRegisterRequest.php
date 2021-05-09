<?php

namespace App\Http\Requests\API\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class ClientAuthRegisterRequest extends FormRequest
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
            'email' => 'required|email|unique:clients',
            'phone' => 'required|min:10|unique:clients',
            'country' => 'required',
            'job' => 'required',
            'identity_no' => 'required',
            'password' => 'required|confirmed|min:8',
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
            'email.required' => 'البريد الألكتروني مطلوب',
            'email.unique' => 'البريد الألكتروني مستخدم بالفعل',
            'email.email' => 'يجب ان يكون المدخل بريد ألكتروني',
            'phone.required' => 'رقم الهاتف مطلوب',
            'phone.min' => 'يجب أن يكون رقم الهاتف 10 ارقام',
            'phone.unique' => 'رقم الهاتف مستخدم بالفعل',
            'country.required' => 'البلاد مطلوبة',
            'job.required' => 'الوظيفة مطلوبة',
            'identity_no.required' => 'رقم الهوية مطلوب',
            'password.required' => 'كلمة السر مطلوبة',
            'password.min' => 'طول الحد الأدني هو 8',
            'password.confirmed' => 'كلمة المرور لا تتطابق مع تأكيد كلمة المرور',
        ];
    }

}
