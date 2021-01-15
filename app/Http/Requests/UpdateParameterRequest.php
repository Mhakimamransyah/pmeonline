<?php

namespace App\Http\Requests;

use App\Parameter;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateParameterRequest extends FormRequest
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
            'id' => 'required|exists:parameters',
            'label' => 'required',
            'unit' => ''
        ];
    }

    /**
     * @return Parameter|mixed
     */
    public function getParameter()
    {
        return Parameter::query()->findOrFail($this->get('id'));
    }
}
