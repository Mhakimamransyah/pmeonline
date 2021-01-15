<?php

namespace App\Http\Controllers\Participant;

use App\Cycle;
use App\Http\Controllers\Controller;
use App\Http\Requests\CancelInvoiceRequest;
use App\Http\Requests\CreateOrderRequest;
use App\Http\Requests\ShowInvoiceRequest;
use App\Invoice;
use App\Order;
use App\Package;
use App\User;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'participant']);
    }

    public function index()
    {
        $user = Auth::user();
        if (!$user instanceof User) { abort(500); }
        return $this->indexInvoices($user);
    }

    public function show(ShowInvoiceRequest $request)
    {
        $user = Auth::user();
        if (!$user instanceof User) { abort(500); }
        return $this->showInvoice($request->getInvoice(), $user);
    }

    public function showCreateForm()
    {
        $user = Auth::user();
        if (!$user instanceof User) { abort(500); }
        $cycles = Cycle::openRegistration()->get();
        $packageCount = 0;
        foreach ($cycles as $cycle) {
            if (!$cycle instanceof Cycle) { abort(500); }
            $packageCount += $cycle->getPackages()->count();
        }
        if ($packageCount > 0) {
            return view('participant.invoice.create', [
                'laboratories' => $user->getLaboratories(),
                'cycles' => Cycle::openRegistration()->get(),
            ]);
        } else {
            return view('participant.invoice.no-item-create');
        }
    }

    public function create(CreateOrderRequest $request)
    {
        $invoice = (new Invoice)
            ->setLaboratory($request->getLaboratory())
            ->setTotalCost($this->calculateTotalCost(array_keys($request->get('selected_packages'))));
        $invoice->save();

        foreach (array_keys($request->get('selected_packages')) as $packageId) {
            $package = Package::query()->findOrFail($packageId);
            if ($package instanceof Package) {
                (new Order)
                    ->setInvoice($invoice)
                    ->setPackage($package)
                    ->setSubtotal($package->getTariff())
                    ->save();
            }
        }
        return redirect()->route('participant.invoice.show', ['id' => $invoice->getId()])
            ->with(['success' => 'Pesanan berhasil dibuat. Silakan lakukan pembayaran dan lakukan konfirmasi.']);
    }

    public function cancel(CancelInvoiceRequest $request)
    {
        $user = Auth::user();
        if (!$user instanceof User) { abort(500); }
        return $this->cancelInvoice($request->getInvoice(), $user);
    }

    private function indexInvoices(User $user)
    {
        return view('participant.invoice.index', [
            'invoices' => $user->getInvoices(),
        ]);
    }

    private function showInvoice(Invoice $invoice, User $user)
    {
        if (!$invoice->getLaboratory()->getUser()->is($user)) {
            return abort(403);
        }
        return view('participant.invoice.show', [
            'invoice' => $invoice,
        ]);
    }

    private function cancelInvoice(Invoice $invoice, User $user)
    {
        if (!$invoice->getLaboratory()->getUser()->is($user)) {
            return abort(403);
        }
        $invoiceId = $invoice->getId();
        $invoice->delete();
        return redirect()->route('participant.invoice.index')->with(['success' => 'Tagihan #' . $invoiceId . ' berhasil dibatalkan.']);
    }

    /**
     * Calculate total cost of received packages.
     *
     * @param array $packageIds
     * @return float
     */
    private function calculateTotalCost(array $packageIds)
    {
        return Package::query()->findMany($packageIds)->sum(function ($item) {
            if ($item instanceof Package) {
                return $item->getTariff();
            }
            return 0;
        });
    }
}
