<?php

namespace App\Http\Requests;

use App\ItemOption;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateItemOptionRequest extends FormRequest
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
            'table_name' => 'required',
            'value' => 'required|unique:' . $this->get('table_name'),
            'text' => 'required|unique:' . $this->get('table_name'),
        ];
    }

    /**
     * @return ItemOption
     */
    public function getItemOption()
    {
        return (new ItemOption)
            ->setTable($this->get('table_name'));
    }
}
