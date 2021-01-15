<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Requests\ShowPaymentByPaymentIdRequest;
use App\Http\Requests\UpdatePaymentRequest;
use App\Payment;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'administrator']);
    }

    public function index()
    {
        return view('administrator.payment.index', [
            'payments' => Payment::all(),
        ]);
    }

    public function show(ShowPaymentByPaymentIdRequest $request)
    {
        return view('administrator.payment.show', [
            'payment' => $request->getPayment(),
        ]);
    }

    public function update(UpdatePaymentRequest $request)
    {
        $payment = $request->getPayment()->fill($request->except(['id']));
        $payment->save();
        return redirect()->route('administrator.payment.index')->with([
            'success' => 'Pembayaran tagihan #' . $payment->getInvoice()->getId() . ' a.n. ' . $payment->getInvoice()->getLaboratory()->getName() . ' diverifikasi sebagai ' . $payment->getStateLabel() . '.'
        ]);
    }
}
