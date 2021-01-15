<?php

namespace App\Http\Controllers\Installation;

use App\v3\Order;
use App\v3\Package;
use App\v3\Submit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RekapIsianController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'installation']);
    }

    public function index(Request $request)
    {
        if ($request->has('package_id')) {
            $package = Package::findOrFail($request->get('package_id'));
            $submits = $package->orders()->get()->flatMap(function (Order $order) {
                return $order->submit()->with(['order', 'order.invoice', 'order.invoice.laboratory'])->get();
            })->filter(function (Submit $submit) use ($package) {
                if ($package->cycle_id <= 2) {
                    return $submit->sent;
                }
                return $submit->verified;
            });
            return view('instalasi.rekap-isian.content', [
                'package' => $package,
                'submits' => $submits->values(),
            ]);
        }
        return view('instalasi.rekap-isian.index');
    }
}
