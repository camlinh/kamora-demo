<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth('admin')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ' required|max:255',
            'email' => ' required|max:255|email|unique:users,email,'.$this->id.',id',
            'address' => ' required',
            'gender' => ' required',
        ];
    }

    public function getData(){
      return $this->only(['name', 'email', 'address', 'gender']);
    }
}
