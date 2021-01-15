<?php

namespace App\Http\Requests;

use App\LaboratoryType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateLaboratoryTypeRequest extends FormRequest
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
            'name' => 'required|string|max:255'
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Nama tipe instansi'
        ];
    }

    /**
     * @return LaboratoryType|mixed
     */
    public function getLaboratoryType()
    {
        return LaboratoryType::query()->findOrFail($this->get('id'));
    }
}
