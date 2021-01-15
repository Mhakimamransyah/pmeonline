<?php

namespace App\Http\Controllers\Division\Immunology;

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
        if ($parameter->label == 'Anti HIV') {
            $view = 'division.immunology.statistic.index-antihiv';
        }
        if ($parameter->label == 'HBsAg') {
            $view = 'division.immunology.statistic.index-hbsag';
        }
        if ($parameter->label == 'Anti HCV') {
            $view = 'division.immunology.statistic.index-hbsag';
        }
        if ($parameter->label == 'TPHA') {
            $view = 'division.immunology.statistic.index-tpha';
        }
        if ($parameter->label == 'RPR') {
            $view = 'division.immunology.statistic.index-rpr';
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
                if (in_array($parameter->label, ['HBsAg', 'Anti HCV'])) {
                    $submit->computed->value->metode = $value->{'metode_pemeriksaan'};
                    $submit->computed->value->reagen = $value->{'nama_reagen'};
                    $submit->computed->value->produsen = $value->{'nama_produsen'};
                    $submit->computed->value->batch = $value->{'nama_lot_atau_batch'};
                }
                if (in_array($parameter->label, ['TPHA', 'RPR'])) {
                    $submit->computed->value->metode = $value->{'metode'};
                    $submit->computed->value->reagen = $value->{'nama_reagen'};
                    $submit->computed->value->produsen = $value->{'nama_produsen_reagen'};
                    $submit->computed->value->batch = $value->{'lot_reagen'};
                }
                if (in_array($parameter->label, ['Anti HIV'])) {
                    $submit->computed->value->reagen = new \stdClass();
                    $submit->computed->value->batch = new \stdClass();
                    for ($tes = 1; $tes <= 3; $tes++) {
                        $submit->computed->value->reagen->{'tes_'.$tes} = $value->{'reagen_tes'.$tes};
                        $submit->computed->value->batch->{'tes_'.$tes} = $value->{'batch_tes'.$tes};
                    }
                }
                for ($sediaan = 0; $sediaan < 3; $sediaan++) {
                    if (in_array($parameter->label, ['HBsAg', 'Anti HCV'])) {
                        $submit->computed->value->{'sediaan_'.$sediaan} = $this->createParameterHbsAgStatisticTable($value, $sediaan);
                    }
                    if (in_array($parameter->label, ['TPHA'])) {
                        $submit->computed->value->{'sediaan_'.$sediaan} = $this->createParameterTPHAStatisticTable($value, $sediaan);
                    }
                    if (in_array($parameter->label, ['RPR'])) {
                        $submit->computed->value->{'sediaan_'.$sediaan} = $this->createParameterRPRStatisticTable($value, $sediaan);
                    }
                    if (in_array($parameter->label, ['Anti HIV'])) {
                        $submit->computed->value->{'sediaan_'.$sediaan} = $this->createParameterAntiHIVStatisticTable($value, $sediaan);
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

    private function createParameterHbsAgStatisticTable($sourceData, $sediaanId)
    {
        $result = new \stdClass();
        $result->kode = $sourceData->{'kode_panel_'.$sediaanId};
        $result->abs = $sourceData->{'abs_'.$sediaanId};
        $result->cut = $sourceData->{'cut_'.$sediaanId};
        $result->sco = $sourceData->{'sco_'.$sediaanId};
        $result->hasil = $sourceData->{'hasil_'.$sediaanId};
        return $result;
    }

    private function createParameterTPHAStatisticTable($sourceData, $sediaanId)
    {
        $result = new \stdClass();
        $result->kode = $sourceData->{'kode_panel_'.$sediaanId};
        $result->abs = $sourceData->{'kualitatif_abs_'.$sediaanId};
        $result->cut = $sourceData->{'kualitatif_cut_'.$sediaanId};
        $result->sco = $sourceData->{'kualitatif_sco_'.$sediaanId};
        $result->hasil = $sourceData->{'hasil_'.$sediaanId};
        $result->hasil_semi_kuantitatif = $sourceData->{'hasil_semi_kuantitatif_'.$sediaanId};
        $result->titer = $sourceData->{'titer_'.$sediaanId};
        return $result;
    }

    private function createParameterRPRStatisticTable($sourceData, $sediaanId)
    {
        $result = new \stdClass();
        $result->kode = $sourceData->{'kode_panel_'.$sediaanId};
        $result->hasil_semi_kuantitatif = $sourceData->{'hasil_semi_kuantitatif_'.$sediaanId};
        $result->titer = $sourceData->{'titer_'.$sediaanId};
        return $result;
    }

    private function createParameterAntiHIVStatisticTable($sourceData, $sediaanId)
    {
        $result = new \stdClass();
        for ($tes = 1; $tes <= 3; $tes++) {
            $result->{'tes_'.$tes} = new \stdClass();
            $result->{'tes_'.$tes}->abs = $sourceData->{'abs_panel_'.$sediaanId.'_tes_'.$tes};
            $result->{'tes_'.$tes}->cut = $sourceData->{'cut_panel_'.$sediaanId.'_tes_'.$tes};
            $result->{'tes_'.$tes}->sco = $sourceData->{'sco_panel_'.$sediaanId.'_tes_'.$tes};
            $result->{'tes_'.$tes}->hasil = $sourceData->{'hasil_panel_'.$sediaanId.'_tes_'.$tes};
        }
        $result->kode = $sourceData->{'kode_panel_'.$sediaanId};
        return $result;
    }
}
