<?php

namespace App\Http\Requests\Backend\Auth\Admin;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdateAdminRequest.
 */
class UpdateAdminRequest extends FormRequest
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
            'email' => 'required|email|max:191',
            'first_name'  => 'required|max:191',
            'last_name'  => 'required|max:191',
            'timezone' => 'required|max:191',
            'roles' => 'required|array',
        ];
    }
}
