<?php

namespace App\Http\Controllers\Division\HealthChemical;

use App\Parameter;
use App\Submit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ParameterController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'installation']);
    }

    public function showStatistic(Request $request)
    {
        $parameter = Parameter::findOrFail($request->get('id'));
        return view('division.health-chemical.statistic.index', [
            'parameter' => $parameter,
            'results' => $this->showStatisticForParameter($parameter),
        ]);
    }

    public function showStatisticForParameter(Parameter $parameter)
    {
        return Submit::query()->where('value', '!=', null)
            ->get()
            ->filter(function (Submit $submit) use ($parameter) {
                return $submit->order->package->parameters->contains($parameter);
            })
            ->each(function (Submit $submit) use ($parameter) {
                $value = json_decode($submit->getValue());
                $parameter_id_on_value = str_replace(' ', '_', $parameter->label);
                $submit->computed = new \stdClass();
                $submit->computed->id = $submit->id;
                $submit->computed->order = $submit->order()->without(['package.parameters'])->with(['invoice.laboratory'])->get()->first();
                $submit->computed->value = new \stdClass();
                $submit->computed->value = $this->createHealthChemicalParameterStatisticTable($value, $parameter_id_on_value);
                $submit->computed->value->parameterLabel = $parameter->label;
                $submit->computed->sent = $submit->sent;
                $submit->computed->verified = $submit->verified;
                $submit->computed->created_at = $submit->created_at;
                $submit->computed->updated_at = $submit->updated_at;
            })
            ->map(function ($item) {
                return $item->computed;
            })
            ->values()
            ->toArray();
    }

    private function createHealthChemicalParameterStatisticTable($sourceData, $parameterId)
    {
        $result = new \stdClass();
        $result->metode_pemeriksaan = $sourceData->{'metode_'.$parameterId} ?? null;
        $result->ketidakpastian = $sourceData->{'ketidakpastian_'.$parameterId} ?? null;
        $result->hasil = $sourceData->{'hasil_pengujian_'.$parameterId} ?? null;
        return $result;
    }
}
