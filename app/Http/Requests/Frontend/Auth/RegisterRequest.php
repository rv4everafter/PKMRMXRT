<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Arcanedev\NoCaptcha\Rules\CaptchaRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Auth\User;

/**
 * Class RegisterRequest.
 */
class RegisterRequest extends FormRequest
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
            'enroller_id'          => 'required|string|max:10',
            'sponsor_id'           => 'required|string|max:10',
            'dob'                  => 'required|string|max:20',
            'phone'                => 'required|string|max:10',
            'first_name'           => 'required|string|max:255',
            'last_name'            => 'required|string|max:255',
            'email'                => ['required', 'string', 'email', 'max:255', Rule::unique('users')],
            'password'             => 'required|string|min:8|confirmed',
            'g-recaptcha-response' => ['required_if:captcha_status,true', new CaptchaRule()],
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'g-recaptcha-response.required_if' => __('validation.required', ['attribute' => 'captcha']),
        ];
    }
}
