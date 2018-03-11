<?php

namespace App\Http\Requests\Backend\Auth\User;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StoreUserRequest.
 */
class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->isAdmin();
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
            'first_name'     => 'required|max:191',
            'last_name'  => 'required|max:191',
            'email'    => ['required', 'email', 'max:191', Rule::unique('users')],
//            'timezone' => 'required|max:191',
            'password' => 'required|min:6|confirmed',
//            'roles' => 'required|array',
        ];
    }
}
