<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateCycleRequest extends FormRequest
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
     * @return Carbon|CarbonInterface
     */
    public function getStartRegistrationDate()
    {
        return Carbon::create($this->get('start_registration_date'));
    }

    /**
     * @return Carbon|CarbonInterface
     */
    public function getEndRegistrationDate()
    {
        return Carbon::create($this->get('end_registration_date'));
    }

    /**
     * @return Carbon|CarbonInterface
     */
    public function getStartSubmitDate()
    {
        return Carbon::create($this->get('start_submit_date'));
    }

    /**
     * @return Carbon|CarbonInterface
     */
    public function getEndSubmitDate()
    {
        return Carbon::create($this->get('end_submit_date'));
    }
}
