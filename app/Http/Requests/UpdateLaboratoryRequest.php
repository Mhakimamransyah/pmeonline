<?php

namespace App\Http\Requests;

use App\Laboratory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateLaboratoryRequest extends FormRequest
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
        $laboratory = Laboratory::query()->findOrFail($this->get('id'));
        if (!$laboratory instanceof Laboratory) { abort(500); }
        return [
            'name' => 'required|string|max:255',
            'type_id' => 'required|exists:laboratory_types,id',
            'ownership_id' => 'required|exists:laboratory_ownerships,id',
            'email' => ['required', 'string', 'max:255', Rule::unique('laboratories')->ignore($laboratory->getId()), 'email'],
            'phone_number' => ['required', 'numeric', 'digits_between:6,36', Rule::unique('laboratories')->ignore($laboratory->getId())],
            'address' => 'required|string|max:255',
            'village' => 'required|string|max:128',
            'district' => 'required|string|max:128',
            'city' => 'required|string|max:128',
            'province_id' => 'required|exists:provinces,id',
            'postal_code' => 'required|numeric|digits_between:4,6',
        ];
    }

    /**
     * @return Laboratory|mixed
     */
    public function getLaboratory()
    {
        return Laboratory::query()->findOrFail($this->get('id'));
    }
}
