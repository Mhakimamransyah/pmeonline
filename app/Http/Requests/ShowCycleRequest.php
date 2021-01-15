<?php

namespace App\Http\Requests;

use App\Cycle;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ShowCycleRequest extends FormRequest
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
            'id' => 'required|exists:cycles'
        ];
    }

    /**
     * @return Cycle|mixed
     */
    public function getCycle()
    {
        return Cycle::query()->findOrFail($this->get('id'));
    }
}
