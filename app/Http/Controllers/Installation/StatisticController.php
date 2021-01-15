<?php

namespace App\Http\Controllers\Installation;

use App\v3\Submit;
use App\v3\Order;
use App\v3\Package;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StatisticController extends Controller
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
            $score = $submits->values()[0]->order->score;
            return view('instalasi.statistic.content', [
                'package' => $package,
                'submits' => $submits->values(),
                'score' => $score,
            ]);
        }
        return view('instalasi.statistic.index');
    }
}
