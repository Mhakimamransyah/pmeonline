<?php

namespace App\Http\Requests;

use App\Invoice;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreatePaymentRequest extends FormRequest
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
            'invoice_id' => 'required|exists:invoices,id',
            'evidence' => 'file|image|required|max:1536'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'evidence' => 'Bukti pembayaran'
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'image' => ':attribute harus berupa berkas gambar (jpeg, png, atau bmp).',
            'max' => ':attribute harus berukuran lebih kecil dari :max kilobyte.',
            'file' => ':attribute gagal diunggah.',
        ];
    }

    /**
     * @return Invoice|mixed
     */
    public function getInvoice()
    {
        return Invoice::query()->findOrFail($this->get('invoice_id'));
    }
}
