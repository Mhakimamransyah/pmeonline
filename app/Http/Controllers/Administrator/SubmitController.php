<?php

namespace App\Http\Controllers\Administrator;

use App\Cycle;
use App\Http\Requests\ShowSubmitRequest;
use App\Invoice;
use App\Laboratory;
use App\Order;
use App\Package;
use App\Submit;
use App\Http\Controllers\Controller;
use App\User;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubmitController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'administrator']);
    }

    public function index(Request $request)
    {
        $cycleId = $request->get('cycle_id');
        $laboratoryId = $request->get('laboratory_id');
        if ($cycleId != null && $laboratoryId == null) {
            $packagesId = Package::query()
                ->where('cycle_id', '=', $cycleId)
                ->get()
                ->map(function ($package) {
                    return $package->id;
                })
                ->toArray();
            $ordersId = Order::query()
                ->whereIn('package_id', $packagesId)
                ->get()
                ->map(function ($order) {
                    return $order->id;
                })
                ->toArray();
        } else {
            $invoicesId = $this->filterInvoicesIdByLaboratoryId($laboratoryId);
            $ordersId = $this->filterOrdersIdByInvoicesIdAndCycleId($invoicesId, $cycleId);
        }
        $result = Order::query()
            ->whereIn('id', $ordersId)
            ->get()
            ->filter(function ($order) {
                return $order->invoice != null && $order->invoice->is_eligible_to_submit;
            });
        $stateId = $request->get('state_id');
        if ($stateId != null) {
            if ($stateId == 1) {                                // Belum Diisi
                $result = $result->filter(function ($order) {
                    return $order->submit == null || $order->submit->value == null;
                });
            } elseif ($stateId == 2) {                          // Belum Dikirim
                $result = $result->filter(function ($order) {
                    return $order->submit != null && $order->submit->value != null && $order->submit->sent == false && $order->submit->verified == false;
                });
            } elseif ($stateId == 3) {                          // Terkirim & Belum Terverifikasi
                $result = $result->filter(function ($order) {
                    return $order->submit != null && $order->submit->value != null && $order->submit->sent == true && $order->submit->verified == false;
                });
            } elseif ($stateId == 4) {                          // Terverifikasi
                $result = $result->filter(function ($order) {
                    return $order->submit != null && $order->submit->value != null && $order->submit->verified == true;
                });
            }
        }
        if ($cycleId == null && $laboratoryId == null && $stateId != null) {
            $orders = Order::all()->filter(function ($order) {
                return $order->invoice != null;
            });
            if ($stateId == 1) {                                // Belum Diisi
                $result = $orders->filter(function ($order) {
                    return $order->submit == null || $order->submit->value == null;
                });
            } elseif ($stateId == 2) {                          // Belum Dikirim
                $result = $orders->filter(function ($order) {
                    return $order->submit != null && $order->submit->value != null && $order->submit->sent == false && $order->submit->verified == false;
                });
            } elseif ($stateId == 3) {                          // Terkirim & Belum Terverifikasi
                $result = $orders->filter(function ($order) {
                    return $order->submit != null && $order->submit->value != null && $order->submit->sent == true && $order->submit->verified == false;
                });
            } elseif ($stateId == 4) {                          // Terverifikasi
                $result = $orders->filter(function ($order) {
                    return $order->submit != null && $order->submit->value != null && $order->submit->verified == true;
                });
            }
        }
        return view('administrator.submit.index', [
            'optionCycles' => Cycle::all(),
            'optionLaboratories' => Laboratory::all(),
            'result' => $result,
        ]);
    }

    private function filterInvoicesIdByLaboratoryId($laboratoryId)
    {
        return Invoice::query()
            ->where('laboratory_id', '=', $laboratoryId)
            ->get()
            ->map(function ($invoice) {
                return $invoice->id;
            })
            ->toArray();
    }

    public function filterOrdersIdByInvoicesIdAndCycleId(array $invoicesId, $cycleId)
    {
        return Order::query()
            ->whereIn('invoice_id', $invoicesId)
            ->get()
            ->filter(function ($order) use ($cycleId) {
                return $cycleId == null ? true : $order->package->cycle_id == $cycleId;
            })
            ->map(function ($order) {
                return $order->id;
            })
            ->toArray();
    }

    public function show(ShowSubmitRequest $request)
    {
        return $this->showSubmit($request->getOrder());
    }

    private function showSubmit(Order $fromOrder)
    {
        if ($fromOrder->getInvoice() == null) {
            return abort(404);
        }
        $submit = Submit::query()->firstOrCreate([
            'order_id' => $fromOrder->getId()
        ]);
        if (!$submit instanceof Submit) {
            return abort(500);
        }
        return view('form.index', [
            'form' => $submit->getOrder()->getPackage()->getName(),
            'route' => route('administrator.submit.save', ['order_id' => $fromOrder->id]),
            'submit' => $submit,
            'value' => $submit->getValue(),
            'package' => $submit->getOrder()->getPackage(),
        ]);
    }

    public function showSubmitData(ShowSubmitRequest $request)
    {
        return $request->getOrder()->getSubmit()->getValue();
    }

    public function preview(ShowSubmitRequest $request)
    {
        $user = Auth::user();
        if (!$user instanceof User) { return abort(500); }
        return $this->showPreview($request->getOrder(), $user, $request);
    }

    public function showPreview(Order $fromOrder, User $forUser, Request $request)
    {
        if ($fromOrder->getInvoice() == null) {
            return abort(404);
        }
        if (!$forUser->isAdministrator()) {
            return abort(403);
        }
        $submit = Submit::query()->firstOrCreate([
            'order_id' => $fromOrder->getId()
        ]);
        if (!$submit instanceof Submit) {
            return abort(500);
        }
        if ($submit->value == null) {
            return redirect()->back()->withErrors(["Formulir isian ini belum pernah disimpan sebelumnya"]);
        }
        $data = [
            'name' => $submit->getOrder()->getPackage()->getName(),
            'submit' => $submit,
            'value' => $submit->getValue(),
            'downloadLink' => route('administrator.submit.download', ['order_id' => request()->get('order_id')]),
            'printLink' => route('administrator.submit.print', ['order_id' => request()->get('order_id')]),
        ];
        if ($request->has('debug')) {
            return $data;
        }
        return view('preview.index', $data);
    }

    public function save(Request $request)
    {
        $submit = Submit::query()->firstOrCreate(['order_id' => $request->get('order_id')]);
        $submit->value = json_encode($request->all());
        if ($request->has('sent')) {
            $submit->sent = $request->get('sent');
        }
        if ($request->has('verified')) {
            $submit->verified = $request->get('verified');
        }
        $submit->save();
        return back()->with(['success' => 'Perubahan Tersimpan']);
    }

    public function print(ShowSubmitRequest $request)
    {
        $submit = Submit::query()->firstOrCreate(['order_id' => $request->get('order_id')]);
        $view = view('print.index', [
            'name' => $submit->getOrder()->getPackage()->getName(),
        ]);
        $dompdf = new Dompdf();
        $dompdf->loadHtml($view);
        $dompdf->setPaper('A4', 'p');
        $dompdf->render();
        $dompdf->stream('Output PME - ' . time() . '.pdf', ['Attachment' => 0]);
    }

    public function download(ShowSubmitRequest $request)
    {
        $submit = Submit::query()->firstOrCreate(['order_id' => $request->get('order_id')]);
        $view = view('print.index', [
            'name' => $submit->getOrder()->getPackage()->getName(),
        ]);
        $dompdf = new Dompdf();
        $dompdf->loadHtml($view);
        $dompdf->setPaper('A4', 'p');
        $dompdf->render();
        $dompdf->stream('Output PME - ' . time() . '.pdf', ['Attachment' => 1]);
    }
}
