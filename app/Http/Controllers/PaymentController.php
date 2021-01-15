<?php

namespace App\Http\Controllers;

use App\Participant;
use App\Payment;
use App\Traits\AdministratorControllerTrait;
use App\VerifyPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    use AdministratorControllerTrait;

    public function __construct()
    {
        $administratorMethods = [
            'displayList', 'displayItem', 'verifyItem',
        ];
        $this->middleware(['auth', 'participant'])->except($administratorMethods);
        $this->middleware(['auth', 'administrator'])->only($administratorMethods);
    }

    public function postCreatePayment(Request $request)
    {
        $evidence = $request->file('evidence');
        $file = Storage::put('public/payment-confirmation', $evidence);
        Payment::create([
            'evidence' => $file,
            'invoice_id' => $request->get('invoice_id'),
            'note' => $request->get('note'),
        ]);
        return view('participant.invoice.confirmation-sent');
    }

    public function displayList()
    {
        return view('admin.payment-confirmation.list', [
            'payments' => Payment::all(),
        ]);
    }

    public function displayItem($id)
    {
        return view('admin.payment-confirmation.item', [
            'payment' => Payment::findOrFail($id),
        ]);
    }

    public function verifyItem(Request $request, $id)
    {
        VerifyPayment::firstOrCreate([
            'payment_id' => $id,
            'verified' => $request->get('action') == 'accept',
            'administrator_id' => $this->findAdministrator()->id,
            'note' => $request->get('note'),
        ]);
        if ($request->get('action') == 'accept') {
            $payment = Payment::findOrFail($id);
            foreach ($payment->orders as $order) {
                Participant::create([
                    'number' => Participant::all()->count() + 1,
                    'order_id' => $order->id,
                ]);
            }
        }
        return redirect()->route('administrator.payment-confirmation.list');
    }
}
