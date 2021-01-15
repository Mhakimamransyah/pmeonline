<?php

namespace App\Http\Requests;

use App\Package;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdatePackageRequest extends FormRequest
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
            'id' => 'required|exists:packages',
            'name' => 'required',
            'label' => 'required',
            'tariff' => 'required|numeric',
            'quota' => 'required|numeric'
        ];
    }

    /**
     * @return Package|mixed
     */
    public function getPackage()
    {
        return Package::query()->findOrFail($this->get('id'));
    }
}
