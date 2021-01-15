<?php

namespace App\Http\Controllers\v1\Installation;

use App\Http\Controllers\Controller;
use App\LittleFlower\InputController;
use App\OrderPackage;
use App\Parameter;
use App\ScoreInput;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ScoreController extends Controller
{

    public function __construct()
    {
        $this->middleware('installation');
    }

    public function itemView(Request $request, $id)
    {
        $score_input = ScoreInput::findOrFail($id);
        $orderPackage = OrderPackage::with(['package', 'order', 'package.parameters'])->findOrFail($score_input->order_package_id);
        $form = $orderPackage->package->form;

        if ($orderPackage->package->id == 12) {
            $parameter_id = 50;
            $parameter = Parameter::findOrFail($parameter_id)->load(['packages', 'packages.subject']);
            $package = $parameter->packages[0];
            $data = [
                'parameter' => $parameter,
            ];
            $statistic_all = Collection::make(InputController::proceed2($package->id));
            $data['statistic'] = $statistic_all->filter(function ($item) use ($id) {
                $result = null;
                foreach ($item->data as $dataItem) {
                    if ($dataItem->score_id == $id) {
                        $result = $dataItem;
                    }
                }
                return $result;
            })->values();
            for ($i = 0; $i < count($data['statistic'][0]->data); $i++) {
                if ($data['statistic'][0]->data[$i]->score_id != $id) {
                    unset($data['statistic'][0]->data[$i]);
                }
            }
            $data['statistic'][0]->data = $data['statistic'][0]->data->values();
            $data['cultures'] = [
                '1' => [
                    'Ampicillin',
                    'Co-trimoxazole',
                    'Cefepime',
                    'Meropenem',
                    'Gentamicin',
                ],
                '2' => [
                    'Cefepime',
                    'Co-trimoxazole',
                    'Meropenem',
                    'Gentamicin',
                    'Ciproflixacine',
                ]
            ];
            if ($request->has('debug')) {
                return $data;
            }
            return view('score.' . $form->name, [
                'data' => $data,
                'orderPackage' => $orderPackage,
            ]);
        }

        if ($form->table_name != null) {
            $result = DB::table($form->table_name)->where(['order_package_id' => $score_input->order_package_id])->get()->first();
            return view('score.' . $form->name, [
                'order_package_id' => $score_input->order_package_id,
                'filled_form' => $result,
                'score' => json_decode($score_input->value),
            ]);
        }
        return abort(404);
    }

    public function indexView()
    {
        return view('v1.installation.score.index');
    }

    public function fetch(Request $request)
    {
        $package_ids = Auth::user()->roles->first()->packages->map(function ($package) {
            return $package->id;
        })->toArray();
        $score_input = ScoreInput::with(['orderPackage', 'orderPackage.order', 'orderPackage.order.laboratory', 'orderPackage.order.cycle', 'orderPackage.package', 'orderPackage.package.display']);
        $score_input = $score_input->get()->filter(function ($item) use ($package_ids) {
            return $item->value != null;
        });
        $score_input = Collection::make(array_values($score_input->toArray()))->filter(function ($item) use ($package_ids) {
            return in_array($item['order_package']['package_id'], $package_ids);
        });
        return array_values($score_input->toArray());
    }

}