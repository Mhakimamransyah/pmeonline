<?php

namespace App\Http\Controllers\v1\Installation;


use App\Http\Controllers\Controller;
use App\LittleFlower\InputController;
use App\Package;
use App\Parameter;
use App\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class StatisticController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'installation'])->only(['index']);
    }

    /**
     * Halaman index.
     *
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $role = Auth::user()->roles->first()->code;
        if ($role == 'installation-kimia-kesehatan') {
            return $this->indexForHealthChemistry($request);
        }
        if ($role == 'installation-mikrobiologi') {
            return $this->indexForMicrobiology($request);
        }
        if ($role == 'installation-imunologi') {
            return $this->indexForImmunology($request);
        }
        if ($role == 'installation-patologi') {
            return $this->indexForPathology($request);
        }
        return [];
    }

    /**
     * Index statistik untuk patologi.
     *
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    private function indexForPathology(Request $request)
    {
        if ($request->has('parameter_id') && $request->has('bottle_id')) {
            return $this->showStatisticForPathology($request, $request->get('parameter_id'), $request->get('bottle_id'));
        }
        $data = [
            'packages' => Package::all()->whereIn('id', [1, 2, 3, 4])->load(['subject', 'parameters'])->values(),
        ];
        if ($request->has('debug')) {
            return $data;
        }
        return view('v1.installation.statistic.index', $data);
    }

    /**
     * Index statistik untuk kimia kesehatan.
     *
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    private function indexForHealthChemistry(Request $request)
    {
        if ($request->has('parameter_id') && $request->has('bottle_id')) {
            return $this->showStatisticForHealthChemistry($request, $request->get('parameter_id'), $request->get('bottle_id'));
        }
        $data = [
            'packages' => Package::all()->whereIn('id', [13])->load(['subject', 'parameters'])->values(),
        ];
        if ($request->has('debug')) {
            return $data;
        }
        return view('v1.installation.statistic.index', $data);
    }

    /**
     * Statistik untuk patologi.
     *
     * @param Request $request
     * @param $parameter_id
     * @param $bottle_id
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    private function showStatisticForPathology(Request $request, $parameter_id, $bottle_id)
    {
        $parameter = Parameter::findOrFail($parameter_id)->load(['packages', 'packages.subject']);
        $package = $parameter->packages[0];
        $statistic = InputController::proceed($package->id);
//        return $statistic;
        foreach ($statistic as $item)
        {
            $item->bottle = $item->bottles[$bottle_id];
            unset($item->bottles);
            $collect_parameters = Collection::make($item->bottle->parameters);
            $item->bottle->parameter = $collect_parameters->first(function ($p) use ($parameter) {
                return $p->name == $parameter->name;
            });
            unset($item->bottle->parameters);
            unset($item->saran);
            unset($item->keterangan);
        }
        $data = [
            'bottle_total' => $package->id == 13 ? 1 : 2,
            'bottle_id' => $bottle_id,
            'parameter' => $parameter,
            'statistic' => $statistic,
        ];
        if ($request->has('debug')) {
            return $data;
        }
        return view('v1.installation.statistic.item_patologi', $data);
    }

    /**
     * Statistik untuk kimia kesehatan.
     *
     * @param Request $request
     * @param $parameter_id
     * @param $bottle_id
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    private function showStatisticForHealthChemistry(Request $request, $parameter_id, $bottle_id)
    {
        $parameter = Parameter::findOrFail($parameter_id)->load(['packages', 'packages.subject']);
        $package = $parameter->packages[0];
        $statistic = InputController::proceed($package->id);
        foreach ($statistic as $item)
        {
            $item->bottle = $item->bottles[$bottle_id];
            unset($item->bottles);
            $collect_parameters = Collection::make($item->bottle->parameters);
            $item->bottle->parameter = $collect_parameters->first(function ($p) use ($parameter) {
                return $p->name == $parameter->name;
            });
            unset($item->bottle->parameters);
            unset($item->saran);
        }
        $data = [
            'bottle_total' => $package->id == 13 ? 1 : 2,
            'bottle_id' => $bottle_id,
            'parameter' => $parameter,
            'statistic' => $statistic,
        ];
        if ($request->has('debug')) {
            return $data;
        }
        return view('v1.installation.statistic.item', $data);
    }

    /**
     * Index statistik untuk mikrobiologi.
     *
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    private function indexForMicrobiology(Request $request)
    {
        if ($request->has('parameter_id')) {
            return $this->showStatisticForMicrobiology($request, $request->get('parameter_id'));
        }
        $data = [
            'packages' => Subject::where('name', '=', 'Mikrobiologi')->first()->packages->load(['subject', 'parameters'])->values(),
        ];
        if ($request->has('debug')) {
            return $data;
        }
        return view('v1.installation.statistic.index2', $data);
    }

    /**
     * Statistik untuk mikrobiologi.
     *
     * @param Request $request
     * @param $parameter_id
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    private function showStatisticForMicrobiology(Request $request, $parameter_id)
    {
        $parameter = Parameter::findOrFail($parameter_id)->load(['packages', 'packages.subject']);
        $package = $parameter->packages[0];
        $data = [
            'parameter' => $parameter,
        ];
        if ($parameter_id == 48) { // Malaria
            $data['statistic'] = InputController::proceedMalaria($package->id);
        } else {
            $data['statistic'] = InputController::proceed2($package->id);
        }
        if ($parameter_id == 50) {
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
        }
        if ($request->has('debug')) {
            return $data;
        }
        return view('v1.installation.statistic.item-' . $parameter_id, $data);
    }

    /**
     * Index statistik untuk Imunologi
     *
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    private function indexForImmunology(Request $request)
    {
        if ($request->has('parameter_id')) {
            return $this->showStatisticForImmunology($request, $request->get('parameter_id'));
        }
        $data = [
            'packages' => Subject::where('name', '=', 'Imunologi')->first()->packages->load(['subject', 'parameters'])->values(),
        ];
        if ($request->has('debug')) {
            return $data;
        }
        return view('v1.installation.statistic.index2', $data);
    }

    /**
     * Statistik untuk imunologi.
     *
     * @param Request $request
     * @param $parameter_id
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    private function showStatisticForImmunology(Request $request, $parameter_id)
    {
        $parameter = Parameter::findOrFail($parameter_id)->load(['packages', 'packages.subject']);
        $package = $parameter->packages[0];
        $data = [
            'parameter' => $parameter,
            'statistic' => InputController::proceed2($package->id),
        ];
        if ($request->has('debug')) {
            return $data;
        }
        return view('v1.installation.statistic.item-' . $parameter_id, $data);
    }

}