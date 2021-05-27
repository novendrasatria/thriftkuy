<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name'=>'required|string|max:50', 
            'email'=>'required|email|unique:users',  //data email dbuat unique, untuk mengecek apakah email sudah digunakan untuk users sebelumnya atau belum
            'roles'=>'nullable|string|in:ADMIN,USER' //in:ADMIN,USER berarti inputannya hanya ada 2, ADMIN atau USER
        ];
    }
}
