<?php

namespace App\Http\Controllers\v1\Installation;

use App\Concept\Penilaian\KimiaAir\PenguraiPenilaianKimiaAir;
use App\Http\Controllers\Controller;
use App\LittleFlower\FormInputParser;
use App\LittleFlower\StatisticController;
use App\OrderPackage;
use App\ScoreInput;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScoringController extends Controller
{

    private $penguraiPenilaianKimiaAir;

    public function __construct(PenguraiPenilaianKimiaAir $penguraiPenilaianKimiaAir)
    {
        $this->middleware('installation');
        $this->penguraiPenilaianKimiaAir = $penguraiPenilaianKimiaAir;
    }

    public function itemView($id)
    {
        DB::table('score_inputs')->updateOrInsert([
            'order_package_id' => $id,
        ], [
            'created_at' => new Carbon(),
        ]);
        $orderPackage = OrderPackage::findOrFail($id);
        $form = $orderPackage->package->form;
        if ($form->table_name != null) {
            $result = DB::table($form->table_name)->where(['order_package_id' => $id])->get()->first();
            return view('scoring.' . $form->name, [
                'order_package_id' => $id,
                'filled_form' => $result,
            ]);
        }
        return abort(404);
    }

    public function viewPatologiScore($order_package_id, $bottle_id, Request $request)
    {
        $orderPackage = OrderPackage::findOrFail($order_package_id);
        $form = $orderPackage->package->form;
        $form_input_id = DB::table($form->table_name)->where(['order_package_id' => $order_package_id])->get()->first()->id;

        $bottle_string = "";
        if ($bottle_id == 0) {
            $bottle_string = "SATU";
        }
        if ($bottle_id == 1) {
            $bottle_string = "DUA";
        }

        $form_input = \App\FormInput::find($form_input_id);
        $package_id = $form_input->package()->id;

        if ($package_id == 1) {
            $item = \App\Sanitizer\KimiaKlinikSanitizer::sanitizeItem(FormInputParser::parse($form_input));
        } elseif ($package_id == 2) {
            $item = \App\Sanitizer\HematologiSanitizer::sanitizeItem(FormInputParser::parse($form_input));
        } elseif ($package_id == 3) {
            $item = \App\Sanitizer\UrinalisaSanitizer::sanitizeItem(FormInputParser::parse($form_input));
        } elseif ($package_id == 4) {
            $item = \App\Sanitizer\HemostatisSanitizer::sanitizeItem(FormInputParser::parse($form_input));
        } elseif ($package_id == 13) {
            $item = \App\Sanitizer\KimiaAirSanitizer::sanitizeItem(FormInputParser::parse($form_input));
        } else {
            abort(400);
        }

        $item->result = $item->bottles[$bottle_id];
        unset($item->bottles);

        foreach ($item->result->parameters as $parameter) {
            if ($parameter->hasil != null) {
                $parameter->per_semua = StatisticController::findOverall($package_id, $bottle_id, $parameter->name);
                $parameter->per_metode = StatisticController::findByMethod($package_id, $bottle_id, $parameter->name, $parameter->metode);
                $parameter->per_alat = StatisticController::findByEquipment($package_id, $bottle_id, $parameter->name, $parameter->alat);
            } else {
                $parameter->per_semua = null;
                $parameter->per_metode = null;
                $parameter->per_alat = null;
            }
            if ($package_id == '3' && $parameter->hasil_raw != null) {
                $parameter->per_semua_raw = StatisticController::findOverallRaw($package_id, $bottle_id, $parameter->name);
                $values = array_count_values($parameter->per_semua_raw->toArray());
                $mode = array_search(max($values), $values);
                $parameter->per_semua_raw_target = $mode;
            } else {
                $parameter->per_semua_raw = null;
                $parameter->per_semua_raw_target = null;
            }
        }

        unset($item->saran);
        unset($item->keterangan);
        if ($package_id == '3') {
            $orderPackage->load('order', 'package', 'package.subject', 'order.laboratory', 'order.cycle');
            $response = [
                'order_package' => $orderPackage,
                'bottle_number' => $bottle_id + 1,
                'bottle_string' => $bottle_string,
                'data' => $item,
            ];
            if ($request->has('debug')) {
                return $response;
            } else {
                return view('score.' . $form->name, $response);
            }
        }
        return view('score.' . $form->name, [
            'order_package_id' => $order_package_id,
            'result' => json_encode($item),
            'bottle_number' => $bottle_id + 1,
            'bottle_string' => $bottle_string,
        ]);
    }

    public function viewKimiaKesehatanScore(Request $request, $order_package_id)
    {
        ini_set('max_execution_time', 300); // 5 minutes

        $orderPackage = OrderPackage::findOrFail($order_package_id);
        $form = $orderPackage->package->form;
        $form_input_id = DB::table($form->table_name)->where(['order_package_id' => $order_package_id])->get()->first()->id;

        $client = new Client();
        $result = $client->request('GET', env('SCORING_URL') . '/form-input/' . $form_input_id, [
            'query' => [
                'bottle_id' => '0'
            ]
        ])->getBody();

        if ($request->has('debug')) {
            return $result;
        }
        $result = $this->penguraiPenilaianKimiaAir->urai(json_decode($result));
        return view('score.pnpme-ka-1', ['score' => $result, 'order_package_id' => $order_package_id]);
    }

    public function post($id, Request $request)
    {
        $score = ScoreInput::where('order_package_id', '=', $id)->first();
        $score->value = json_encode($request->all());
        $score->save();
        return redirect()->back()->with(['success' => 'Tersimpan. Lihat <b><a target="_blank" href="/installation/score/' . $score->id . '">laporan hasil penilaian</a></b>.']);
    }

    public function export($package_id, Request $request)
    {
        $mode = 'scoring';
//        $mode = $request->get('mode');

        $order_packages = OrderPackage::with(['order', 'order.laboratory', 'order.cycle', 'input', 'package', 'package.display'])->where('package_id', '=', $package_id)->get();
        if ($mode == 'scoring') {
            $order_packages = $order_packages->filter(function ($item) {
                return $item->input != null && $item->input->sent == 1;
            });
        }
        if ($mode == 'view') {
            $order_packages = $order_packages->filter(function ($item) {
                return $item->input != null && $item->input->value != null;
            });
        }
        if ($mode == 'blank') {
            $order_packages = $order_packages->filter(function ($item) {
                return $item->input == null;
            });
        }

        $input = array();

        foreach ($order_packages as $order_package) {
            array_push($input, json_decode($order_package->input->value));
        }

        return $input;
    }

}
