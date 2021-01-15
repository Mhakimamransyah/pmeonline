<?php

namespace App\Http\Controllers\Participant;

use App\Http\Requests\CreatePaymentRequest;
use App\Http\Requests\ShowCreatePaymentFormRequest;
use App\Http\Requests\ShowPaymentRequest;
use App\Invoice;
use App\Payment;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'participant']);
    }

    public function index()
    {
        return abort(403);
//        $user = Auth::user();
//        if (!$user instanceof User) { abort(500); }
//        return $this->indexInvoicesNeedPayment($user);
    }

    public function show(ShowPaymentRequest $request)
    {
        $user = Auth::user();
        if (!$user instanceof User) { return abort(500); }
        return $this->showPaymentForInvoice($request->getInvoice(), $user);
    }

    private function indexInvoicesNeedPayment(User $user)
    {
        return view('participant.invoice.index', [
            'invoices' => $user->getInvoicesNeedPayment(),
        ]);
    }

    public function showCreateForm(ShowCreatePaymentFormRequest $request)
    {
        $user = Auth::user();
        if (!$user instanceof User) { return abort(500); }
        return $this->showCreatePaymentForm($request->getInvoice(), $user);
    }

    private function showPaymentForInvoice(Invoice $invoice, User $user)
    {
        if (!$invoice->getLaboratory()->getUser()->is($user)) {
            return abort(403);
        }
        return view('participant.payment.show', [
            'invoice' => $invoice,
        ]);
    }

    public function create(CreatePaymentRequest $request)
    {
        $user = Auth::user();
        if (!$user instanceof User) { return abort(500); }
        return $this->createPayment($request, $user);
    }

    private function showCreatePaymentForm(Invoice $invoice, User $user)
    {
        if (!$invoice->getLaboratory()->getUser()->is($user)) {
            return abort(403);
        }
        if (!$invoice->isUnpaid()) {
            return redirect()->route('participant.payment.show', ['invoice_id' => $invoice->getId()]);
        }
        return view('participant.payment.create', [
            'invoice' => $invoice,
        ]);
    }

    private function createPayment(CreatePaymentRequest $request, User $user)
    {
        $invoice = $request->getInvoice();
        if (!$invoice->getLaboratory()->getUser()->is($user)) {
            return abort(403);
        }
        $evidence = $request->file('evidence')->store('public/payment');
        (new Payment)
            ->setEvidence($evidence)
            ->setInvoice($invoice)
            ->setNoteFromParticipant($request->get('note'))
            ->setState(Payment::STATE_WAITING)
            ->save();
        return redirect()->route('participant.payment.index')->with(['success' => 'Konfirmasi pembayaran telah dikirim. Silakan menunggu verifikasi oleh administartor PME.']);
    }
}
