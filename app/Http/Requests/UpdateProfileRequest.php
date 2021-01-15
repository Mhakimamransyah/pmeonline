<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user = Auth::user();
        if (!$user instanceof User) { abort(500); }
        return [
            'name' => 'required|string|max:255',
            'email' => ['required', Rule::unique('users')->ignore($user->getId()), 'string', 'max:255'],
            'phone_number' => ['required', Rule::unique('users')->ignore($user->getId()), 'digits_between:6,36'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => 'Nama',
            'email' => 'Email',
            'phone_number' => "Nomor telepon",
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'required' => ':attribute harus diisi.',
            'unique' => ':attribute sudah digunakan oleh pengguna lain.',
            'max' => ':attribute terlalu panjang (Paling banyak :max karakter).',
            'numeric' => ':attribute hanya boleh berisi angka.',
            'digits_between' => ':attribute hanya boleh berisi angka paling sedikit :min digit dan paling banyak :max digit.',
        ];
    }
}
