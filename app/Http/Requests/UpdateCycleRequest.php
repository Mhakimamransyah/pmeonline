<?php

namespace App\Http\Requests;

use App\Cycle;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateCycleRequest extends FormRequest
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
            'id' => 'required|exists:cycles',
            'name' => 'required',
            'year' => 'required|date_format:Y',
            'start_registration_date' => 'required|date',
            'end_registration_date' => 'required|date',
            'start_submit_date' => 'required|date',
            'end_submit_date' => 'required|date',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Nama siklus',
            'year' => 'Tahun siklus',
            'start_registration_date' => 'Tanggal pendaftaran dibuka',
            'end_registration_date' => 'Tanggal pendaftaran ditutup',
            'start_submit_date' => 'Tanggal pengisian laporan dibuka',
            'end_submit_date' => 'Tanggal pengisian laporan ditutup',
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
