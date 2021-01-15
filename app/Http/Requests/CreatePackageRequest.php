<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreatePackageRequest extends FormRequest
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
            'name' => 'required|unique:packages',
            'label' => 'required',
            'tariff' => 'required|numeric',
            'quota' => 'required|numeric',
            'cycle_id' => 'required|exists:cycles,id'
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Kode paket',
            'label' => 'Nama paket',
            'tariff' => 'Tarif paket',
            'quota' => 'Target peserta paket',
            'cycle_id' => 'Siklus'
        ];
    }
}
