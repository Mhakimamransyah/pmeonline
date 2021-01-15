<?php

namespace App\Http\Controllers\v1\Installation;

use App\Http\Controllers\Controller;
use App\OrderPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FormController extends Controller
{

    public function __construct()
    {
        $this->middleware('installation');
    }

    public function index()
    {
        return view('v1.installation.form.index');
    }

    public function indexScoring()
    {
        return view('v1.installation.form.index', ['mode' => 'scoring']);
    }

    public function indexView()
    {
        return view('v1.installation.form.index', ['mode' => 'view']);
    }

    public function indexBlank()
    {
        return view('v1.installation.form.index', ['mode' => 'blank']);
    }

    public function itemView($id)
    {
        $orderPackage = OrderPackage::findOrFail($id);
        $form = $orderPackage->package->form;
        if ($form->table_name != null) {
            $result = DB::table($form->table_name)->where(['order_package_id' => $id])->get()->first();
            return view('preview.' . $form->name, [
                'order_package_id' => $id,
                'filled_form' => $result,
            ]);
        }
        return view('preview.' . $form->name, [
            'order_package_id' => $id,
        ]);
    }

    public function fetch(Request $request)
    {
        $mode = $request->get('mode');

        $package_ids = Auth::user()->roles->first()->packages->map(function ($package) {
            return $package->id;
        });
        $order_packages = OrderPackage::with(['order', 'order.laboratory', 'order.cycle', 'input', 'package', 'package.display'])->whereIn('package_id', $package_ids)->get();
        if ($mode == 'scoring') {
            $order_packages = $order_packages->filter(function ($item) {
                if ($item->package->id == 10) {
                    $form = DB::table('form_mikrobiologi_malaria_2018_2')->where(['order_package_id' => $item->id])->first();
                    return $form != null && $form->sent == 1;
                }
                return $item->input != null && $item->input->sent == 1;
            });
        }
        if ($mode == 'view') {
            $order_packages = $order_packages->filter(function ($item) {
                if ($item->package->id == 10) {
                    $form = DB::table('form_mikrobiologi_malaria_2018_2')->where(['order_package_id' => $item->id])->first();
                    return $form != null;
                }
                return $item->input != null && $item->input->value != null;
            });
        }
        if ($mode == 'blank') {
            $order_packages = $order_packages->filter(function ($item) {
                if ($item->package->id == 10) {
                    $form = DB::table('form_mikrobiologi_malaria_2018_2')->where(['order_package_id' => $item->id])->first();
                    return $form == null;
                }
                return $item->input == null;
            });
        }
        return $order_packages;
    }

}