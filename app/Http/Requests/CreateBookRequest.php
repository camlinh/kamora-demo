<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateBookRequest extends ApiRequest
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
            'title' => 'required',
            'language' => 'required',
            'author_id' => 'required',
            'thumbnail' => 'required|image|max:10000'
        ];
    }

    public function getData(){
      return $this->only(['title', 'description', 'language', 'author_id']);
    }
}
