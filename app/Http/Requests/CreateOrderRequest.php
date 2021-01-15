<?php

namespace App\Http\Requests;

use App\Laboratory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateOrderRequest extends FormRequest
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
        return [
            'laboratory_id' => 'required|exists:laboratories,id',
            'selected_packages' => 'array|required',
            'acceptance' => 'required'
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
            'laboratory_id.required' => ':attribute harus dipilih.',
            'selected_packages.required' => ':attribute harus dipilih.',
            'acceptance' => 'Pastian Anda telah memeriksa kembali pemesanan Anda.',
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
            'laboratory_id' => 'Laboratorium / Instansi',
            'selected_packages' => 'Paket PME',
        ];
    }

    /**
     * @return Laboratory|mixed
     */
    public function getLaboratory()
    {
        return Laboratory::query()->findOrFail($this->get('laboratory_id'));
    }
}
