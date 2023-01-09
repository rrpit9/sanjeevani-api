<?php

namespace App\Http\Requests\v1;

use App\Models\UserRole;
use Illuminate\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'email_mobile' => 'required|string',
            'password' => 'required|string',
            'device_type' => 'nullable|in:'.implode(',',device_type()),
            'device_token' => 'nullable|string'
        ];
    }

    public function messages()
    {
        return [
            'email_mobile.required' => 'The email or mobile field is required.'
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function (Validator $validator) {
            $loginType = $this->get('login_type');
            if($loginType){
                $userLoginAllowed = UserRole::where([
                    'id' => request()->login_type,
                    'login_allowed' => true
                ])->first();
                if(!$userLoginAllowed){
                    $validator->errors()->add('email_mobile', __('auth.login_not_allowed'));
                }
            }
        });
    }
}
