<?php

namespace App\Http\Controllers\v1\Installation;

use App\Http\Controllers\Controller;
use App\LittleFlower\LaboratoryFinder;
use App\Module\ReportGenerator;
use App\OrderPackage;
use App\PackageFilter;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CertificateController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'installation']);
    }

    public function index()
    {
        return view('v1.installation.certificate.index');
    }

    public function fetch()
    {
        $package_ids = Auth::user()->roles->first()->packages->map(function ($package) {
            return $package->id;
        });
        $order_packages = OrderPackage::with(['order', 'order.laboratory', 'order.cycle', 'input', 'package', 'package.display'])->whereIn('package_id', $package_ids)->get();
        $order_packages = $order_packages->filter(function ($item) {
            if ($item->package->id == 10) {
                $form = DB::table('form_mikrobiologi_malaria_2018_2')->where(['order_package_id' => $item->id])->first();
                return $form != null;
            }
            return $item->input != null && $item->input->value != null;
        });
        return $order_packages;
    }

    public function item($order_package_id)
    {
        $orderPackage = OrderPackage::findOrFail($order_package_id);
        $package_id = $orderPackage->package->id;
        $package_filter = PackageFilter::where('package_id', '=', $package_id)->first();

        $form = $orderPackage->package->form;
        if ($form->tableName == 'form_mikrobiologi_malaria_2018_2') {
            $result = DB::table($form->table_name)->where(['order_package_id' => $order_package_id])->get();
            $value = Collection::make($result[0]);
            return view('v1.installation.certificate.item', [
                'order_package' => $orderPackage,
                'package_id' => $package_id,
                'package_name' => $package_filter->label,
                'laboratory' => LaboratoryFinder::findByOrderPackage($order_package_id),
                'data' => ReportGenerator::sanitizeInput($value, $package_id),
            ]);
        }
        if ($form->table_name != null) {
            $result = DB::table($form->table_name)->where(['order_package_id' => $order_package_id])->get()->first();
            $user_input = json_decode($result->value);
            $user_input->id = $result->id;
            $user_input->order_package_id = $result->order_package_id;
            return view('v1.installation.certificate.item', [
                'order_package' => $orderPackage,
                'package_id' => $package_id,
                'package_name' => $package_filter->label,
                'laboratory' => LaboratoryFinder::findByOrderPackage($order_package_id),
                'data' => ReportGenerator::sanitizeInput($user_input, $package_id),
            ]);
        }
        return view('preview.' . $form->name, [
            'order_package_id' => $order_package_id,
        ]);
    }
}