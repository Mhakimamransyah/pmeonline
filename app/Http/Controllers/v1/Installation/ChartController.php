<?php

namespace App\Http\Controllers\v1\Installation;


use App\Http\Controllers\Controller;
use App\OrderPackage;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'installation']);
    }

    public function viewPatologiChart($order_package_id, $bottle_id)
    {
        ini_set('max_execution_time', 300); // 5 minutes

        $orderPackage = OrderPackage::findOrFail($order_package_id);
        $form = $orderPackage->package->form;
        $form_input_id = DB::table($form->table_name)->where(['order_package_id' => $order_package_id])->get()->first()->id;

        $client = new Client();
        $result = $client->request('GET', env('SCORING_URL') . '/form-input/' . $form_input_id, [
            'query' => [
                'bottle_id' => $bottle_id
            ]
        ])->getBody();

        $bottle_string = "";
        if ($bottle_id == 0) {
            $bottle_string = "SATU";
        }
        if ($bottle_id == 1) {
            $bottle_string = "DUA";
        }

        if ($form->table_name != null) {
            return view('graph.patologi_1', [
                'order_package_id' => $order_package_id,
                'result' => $result,
                'bottle_number' => $bottle_id + 1,
                'bottle_string' => $bottle_string,
            ]);
        }
        return abort(500);
    }

}