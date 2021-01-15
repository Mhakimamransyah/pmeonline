<?php

namespace App\Http\Controllers\v1\Installation;

use App\Http\Controllers\Controller;
use App\Module\ReportGenerator;
use App\Package;
use Illuminate\Http\Request;

class ReportController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'installation']);
    }

    public function index()
    {
        return view('v1.installation.report.index');
    }

    public function create(Request $request, $package_id)
    {
        /**
         * Patologi
         */
        $package = Package::find($package_id);
        $parameter = $request->get('parameter') ?: $package->parameters->first()->name;
        $bottle = $request->get('bottle') ?: 0;
        if ($package_id == 3) {
            return view('v1.installation.report.table1', [
                'reports' => ReportGenerator::proceed($package_id),
                'parameter' => $parameter,
                'bottle' => $bottle,
                'parameters' => $package->parameters,
            ]);
        }
        return view('v1.installation.report.table', [
            'reports' => ReportGenerator::proceed($package_id),
            'parameter' => $parameter,
            'bottle' => $bottle,
            'parameters' => $package->parameters,
        ]);
    }

    public function show($report_id)
    {
        //
    }

}