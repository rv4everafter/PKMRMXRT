<?php

namespace App\Http\Requests\Backend\Auth\Admin;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StoreAdminRequest.
 */
class StoreAdminRequest extends FormRequest
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
            'first_name'     => 'required|max:191',
            'last_name'  => 'required|max:191',
            'email'    => ['required', 'email', 'max:191', Rule::unique('users')],
            'timezone' => 'required|max:191',
            'password' => 'required|min:6|confirmed',
            'roles' => 'required|array',
        ];
    }
}
