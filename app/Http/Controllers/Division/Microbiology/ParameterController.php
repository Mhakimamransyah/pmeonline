<?php

namespace App\Http\Controllers\Division\Microbiology;

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
        $view = '';
        if ($parameter->label == 'BTA') {
            $view = 'division.microbiology.statistic.index-bta';
        }
        if ($parameter->label == 'Malaria') {
            $view = 'division.microbiology.statistic.index-malaria';
        }
        if ($parameter->label == 'Parasit Saluran Pencernaan (Telur Cacing)') {
            $view = 'division.microbiology.statistic.index-cacing';
        }
        return view($view, [
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
                $submit->computed = new \stdClass();
                $submit->computed->id = $submit->id;
                $submit->computed->order = $submit->order()->without(['package.parameters'])->with(['invoice.laboratory'])->get()->first();
                $submit->computed->value = new \stdClass();
                if (in_array($parameter->label, ['BTA', 'Malaria'])) {
                    for ($sediaan = 0; $sediaan < 10; $sediaan++) {
                        if ($parameter->label == 'BTA') {
                            $submit->computed->value->{'sediaan_'.$sediaan} = $this->createParameterBTAStatisticTable($value, $sediaan);
                        }
                        if ($parameter->label == 'Malaria') {
                            $submit->computed->value->{'sediaan_'.$sediaan} = $this->createParameterMalariaStatisticTable($value, $sediaan);
                        }
                    }
                }
                if (in_array($parameter->label, ['Parasit Saluran Pencernaan (Telur Cacing)'])) {
                    for ($sediaan = 0; $sediaan < 2; $sediaan++) {
                        if ($parameter->label == 'Parasit Saluran Pencernaan (Telur Cacing)') {
                            $submit->computed->value->{'sediaan_'.$sediaan} = $this->createParameterCacingStatisticTable($value, $sediaan);
                        }
                    }
                }
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

    private function createParameterBTAStatisticTable($sourceData, $sediaanId)
    {
        $result = new \stdClass();
        $result->kode = $sourceData->{'kode_sediaan_'.$sediaanId} ?? null;
        $result->hasil = $sourceData->{'hasil_'.$sediaanId} ?? null;
        return $result;
    }

    private function createParameterMalariaStatisticTable($sourceData, $sediaanId)
    {
        $result = new \stdClass();
        $result->kode = $sourceData->{'kode_'.$sediaanId} ?? null;
        $result->jumlah = $sourceData->{'jumlah_malaria_'.$sediaanId} ?? null;
        $result->hasil = $sourceData->{'hasil_'.$sediaanId} ?? [];
        return $result;
    }

    private function createParameterCacingStatisticTable($sourceData, $sediaanId)
    {
        $result = new \stdClass();
        $result->kode = $sourceData->{'kode_sediaan_'.$sediaanId} ?? null;
        $result->hasil = $sourceData->{'hasil_'.$sediaanId} ?? [];
        return $result;
    }
}
