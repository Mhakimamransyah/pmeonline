<?php

namespace App\Http\Controllers;

use App\Module\ReportGenerator;
use App\OrderPackage;
use App\PackageFilter;
use Illuminate\Http\Request;

class FormInputController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'installation'])->only(['handle', 'index']);
    }

    public function handle(Request $request)
    {
        if (!$request->has('package_id')) {
            return $this->index();
        }

        $package_id = $request->get('package_id');
        $data = [
            'data' => ReportGenerator::proceed($package_id),
            'title' => PackageFilter::find($package_id)->label,
        ];
        if ($request->has('debug')) {
            return $data;
        }
        return view('v1.installation.all-data.item', $data);
    }

    public function index()
    {
        return view('v1.installation.all-data.index');
    }
}
