<?php

namespace App\Http\Controllers\Administrator;

use App\Cycle;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCycleRequest;
use App\Http\Requests\CreatePackageRequest;
use App\Http\Requests\CreateParameterRequest;
use App\Http\Requests\ShowCycleRequest;
use App\Http\Requests\ShowPackageRequest;
use App\Http\Requests\ShowParameterRequest;
use App\Http\Requests\StoreSignatureRequest;
use App\Http\Requests\UpdateCycleRequest;
use App\Http\Requests\UpdatePackageRequest;
use App\Http\Requests\UpdateParameterRequest;
use App\Laboratory;
use App\Package;
use App\Parameter;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class CycleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'administrator']);
    }

    public function index()
    {
        return view('administrator.cycle.index-v2');
    }

    public function indexData()
    {
        return Cycle::all();
    }

    public function show(ShowCycleRequest $request)
    {
        return view('administrator.cycle.show', [
            'cycle' => $request->getCycle()
        ]);
    }

    public function update(UpdateCycleRequest $request)
    {
        $cycle = $request->getCycle()
            ->fill($request->all());
        $cycle->save();
        return redirect()->back()->with([
            'success' => __('Siklus ' . $cycle->getName() . ' berhasil diperbaharui.')
        ]);
    }

    public function showPackages($cycleId)
    {
        $cycle = Cycle::query()->findOrFail($cycleId);
        if (!$cycle instanceof Cycle) { abort(500); }
        return $this->showPackagesForCycle($cycle);
    }

    private function showPackagesForCycle(Cycle $cycle)
    {
        return view('administrator.cycle.package.index', [
            'cycle' => $cycle,
        ]);
    }

    public function showPackage(ShowPackageRequest $request)
    {
        return view('administrator.cycle.package.show', [
            'package' => $request->getPackage()
        ]);
    }

    public function updatePackage(UpdatePackageRequest $request)
    {
        $package = $request->getPackage()
            ->fill($request->all());
        $package->save();
        return redirect()->back()->with(['success' => 'Paket ' . $package->getLabel() . ' Siklus ' . $package->getCycle()->getName() . ' berhasil diperbaharui.']);
    }

    public function showParameters($packageId)
    {
        $package = Package::query()->findOrFail($packageId);
        if (!$package instanceof Package) { abort(500); }
        return $this->showParametersForPackage($package);
    }

    private function showParametersForPackage(Package $package)
    {
        return view('administrator.cycle.package.parameter.index', [
            'package' => $package,
        ]);
    }

    public function showParameter(ShowParameterRequest $request)
    {
        return view('administrator.cycle.package.parameter.show', [
            'parameter' => $request->getParameter(),
        ]);
    }

    public function updateParameter(UpdateParameterRequest $request)
    {
        $parameter = $request->getParameter()
            ->fill($request->all());
        $parameter->save();
        return redirect()->back()->with(['success' => 'Parameter ' . $parameter->getLabel() . ' berhasil diperbaharui.']);
    }

    public function create(CreateCycleRequest $request)
    {
        $cycle = (new Cycle)->fill($request->all());
        if ($cycle->errors()->isNotEmpty()) {
            return redirect()->back()->withErrors($cycle->errors())->withInput($request->all());
        }
        if (!$cycle->hasNotStarted()) {
            return redirect()->back()->withErrors(Collection::make('Siklus harus dibuat sebelum pendaftaran dibuka.'))->withInput($request->all());
        }
        $cycle->save();
        return redirect()->back()->with(['success' => __('Siklus ' . $cycle->getName() . ' berhasil dibuat.')]);
    }

    public function createPackage(CreatePackageRequest $request)
    {
        $package = (new Package)->fill($request->all());
        $package->save();
        return redirect()->back()->with(['success' => __('Paket ' . $package->getLabel() . ' berhasil dibuat.')]);
    }

    public function createParameter(CreateParameterRequest $request)
    {
        $parameter = (new Parameter)->fill($request->all());
        $parameter->save();
        return redirect()->back()->with(['success' => __('Parameter ' . $parameter->getLabel() . ' berhasil dibuat.')]);
    }

    public function registeredData(Cycle $cycle)
    {
        if (!$cycle instanceof Cycle) { abort(500); }
        return $cycle->getLaboratoriesAttribute()->each(function (Laboratory $laboratory) use ($cycle) {
            $laboratory->selected_invoices = $laboratory->getInvoicesForCycle($cycle);
        });
    }

    public function participantData(Cycle $cycle)
    {
        if (!$cycle instanceof Cycle) { abort(500); }
        return $cycle->getParticipantsAttribute()->each(function (Laboratory $laboratory) use ($cycle) {
            $laboratory->selected_invoices = $laboratory->getInvoicesForCycle($cycle);
        });
    }

    public function registered(Cycle $cycle)
    {
        if (!$cycle instanceof Cycle) { abort(500); }
        return view('administrator.cycle.registered', [
            'cycle' => $cycle,
        ]);
    }

    public function participant(Cycle $cycle)
    {
        if (!$cycle instanceof Cycle) { abort(500); }
        return view('administrator.cycle.participant', [
            'cycle' => $cycle,
        ]);
    }

    public function participantExport(Cycle $cycle)
    {
        if (!$cycle instanceof Cycle) { abort(500); }
        return view('administrator.cycle.participant-export', [
            'cycle' => $cycle,
        ]);
    }

    public function participantExportData(Cycle $cycle)
    {
        if (!$cycle instanceof Cycle) { abort(500); }
        return $cycle->getParticipantsAttribute()->sortBy(function (Laboratory $laboratory) {
            return $laboratory->province_id;
        })->each(function (Laboratory $laboratory) use ($cycle) {
            $laboratory->selected_invoices = $laboratory->getInvoicesForCycle($cycle);
        })->values();
    }

    public function signature(Cycle $cycle)
    {
        return view('administrator.cycle.signature', ['cycle' => $cycle]);
    }

    public function storeSignature(Cycle $cycle, StoreSignatureRequest $request)
    {
        $cycle->fill($request->all());
        $cycle->save();
        return back()->with(['success' => 'Penandatangan hasil evaluasi untuk siklus ' . $cycle->name . ' berhasil disimpan']);
    }

    public function showUnpaidOrders(Cycle $cycle)
    {
        return view('administrator.cycle.unpaid-invoice-list', [
            'invoices' => $cycle->unpaid_orders,
            'cycle' => $cycle
        ]);
    }

    public function deletePackage(Package $packageId)
    {
        $cycleId = $packageId->getCycle()->getId();
        $packageId->delete();
        return redirect()->route('administrator.cycle.package.index', ['cycle' => $cycleId])->with(['success' => "Paket berhasil dihapus."]);
    }

    public function deleteParameter(Parameter $parameter)
    {
        $package = $parameter->getPackage();
        $parameter->delete();
        return redirect()->route('administrator.cycle.package.parameter.index', ['packageId' => $package->getId()])->with(['success' => 'Parameter berhasil dihapus.']);
    }

}
