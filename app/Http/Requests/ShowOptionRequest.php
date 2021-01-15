<?php

namespace App\Http\Requests;

use App\Option;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ShowOptionRequest extends FormRequest
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
            'id' => 'required|exists:options'
        ];
    }

    /**
     * @return Option|mixed
     */
    public function getOption()
    {
        return Option::query()->findOrFail($this->get('id'));
    }
}
