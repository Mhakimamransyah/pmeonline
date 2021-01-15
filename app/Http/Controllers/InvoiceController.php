<?php

namespace App\Http\Controllers;

use App\ContactPerson;
use App\Http\Requests\CancelInvoiceRequest;
use App\Invoice;
use App\OrderPackage;
use App\Traits\ParticipantControllerTraits;
use App\Traits\RupiahFormatterTrait;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    use ParticipantControllerTraits, RupiahFormatterTrait;

    public function __construct()
    {
        $administratorMethods = [
            'filterInvoiceByContactPerson'
        ];
        $this->middleware(['auth', 'participant'])->except($administratorMethods);
        $this->middleware(['auth', 'administrator'])->only($administratorMethods);
    }

    public function createFromOrders(Request $request)
    {
        $invoice = Invoice::create([
            'total_cost' => $request->get('total_cost'),
            'contact_person_id' => $this->findContactPerson()->id,
        ]);
        $invoice->orders()->sync($request->get('orders'));
        return view('participant.invoice.created');
    }

    public function filterInvoiceByContactPerson(Request $request)
    {
        $contactPeopleId = Invoice::all()->map(function ($item, $key) {
            return $item->contact_person_id;
        });
        $contactPeople = ContactPerson::find($contactPeopleId);
        $invoices = null;
        if ($request->isMethod('post')) {
            $invoices = Invoice::where('contact_person_id', '=', $request->get('contact_person'))->get();
        }
        return view('admin.invoice.filter', [
            'contact_people' => $contactPeople,
            'contact_person_id' => $request->get('contact_person') ?: -1,
            'invoices' => $invoices ?: array(),
        ]);
    }
}
