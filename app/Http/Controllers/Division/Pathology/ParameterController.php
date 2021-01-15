<?php

namespace App\Http\Controllers\Division\Pathology;

use App\LittleFlower\InputController;
use App\Parameter;
use App\Http\Controllers\Controller;
use App\Submit;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ParameterController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'installation']);
    }

    public function showStatistic(Request $request)
    {
        $parameter = Parameter::findOrFail($request->get('id'));
        return view('division.pathology.statistic.index', [
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
                $parameter_id_on_value = '';
                if (in_array($parameter->package->name, ['pnpme-kk-2', 'pnpme-hematologi-2', 'pnpme-ur-2'])) {
                    foreach ((array) $value as $k => $v) {
                        if ($v == $parameter->label) {
                            $parameter_id_on_value = substr($k, strrpos($k, '_') + 1);
                            break;
                        }
                    }
                }
                if (in_array($parameter->package->name, ['pnpme-hemostatis-2'])) {
                    if ($parameter->id == 93) {
                        $parameter_id_on_value = 0;
                    }
                    if ($parameter->id == 94) {
                        $parameter_id_on_value = 1;
                    }
                    if ($parameter->id == 95) {
                        $parameter_id_on_value = 2;
                    }
                    if ($parameter->id == 96) {
                        $parameter_id_on_value = 3;
                    }
                }
                $submit->computed = new \stdClass();
                $submit->computed->id = $submit->id;
                $submit->computed->order = $submit->order()->without(['package.parameters'])->with(['invoice.laboratory'])->get()->first();
                $submit->computed->value = new \stdClass();
                $submit->computed->value->parameterLabel = $parameter->label;
                for ($bottle = 1; $bottle <= 2; $bottle++) {
                    if ($parameter->package->name == 'pnpme-kk-2') {
                        $submit->computed->value->{'bottle_'.$bottle} = $this->createHealthClinicParameterStatisticTable($value, $bottle, $parameter_id_on_value);
                    }
                    if ($parameter->package->name == 'pnpme-hematologi-2') {
                        $submit->computed->value->{'bottle_'.$bottle} = $this->createHematologyParameterStatisticTable($value, $bottle, $parameter_id_on_value);
                    }
                    if ($parameter->package->name == 'pnpme-hemostatis-2') {
                        $submit->computed->value->{'bottle_'.$bottle} = $this->createHemostasisParameterStatisticTable($value, $bottle, $parameter_id_on_value);
                    }
                    if ($parameter->package->name == 'pnpme-ur-2') {
                        $submit->computed->value->{'bottle_'.$bottle} = $this->createUrinalysisParameterStatisticTable($value, $bottle, $parameter_id_on_value);
                    }
                }
                $submit->computed->sent = $submit->sent;
                $submit->computed->verified = $submit->verified;
                $submit->computed->created_at = $submit->created_at;
                $submit->computed->updated_at = $submit->updated_at;
            })
            ->map(function ($item) {
                return $item->computed;
            })->filter(function ($item) {
                return $item->value->bottle_1->hasil != null || $item->value->bottle_2->hasil != null;
            })
            ->values()
            ->toArray();
    }

    private function createHealthClinicParameterStatisticTable($sourceData, $bottleId, $parameterId)
    {
        $result = new \stdClass();
        $result->metode_pemeriksaan = $sourceData->{'metode_pemeriksaan_'.$parameterId.'_'.$bottleId} ?? null;
        $result->alat = $sourceData->{'alat_'.$parameterId.'_'.$bottleId} ?? null;
        $result->reagen = $sourceData->{'reagen_'.$parameterId.'_'.$bottleId} ?? null;
        $result->kualifikasi_pemeriksa = $sourceData->{'qualification_'.$parameterId.'_'.$bottleId} ?? null;
        $result->hasil = $sourceData->{'hasil_'.$parameterId.'_'.$bottleId} ?? null;
        return $result;
    }

    private function createHematologyParameterStatisticTable($sourceData, $bottleId, $parameterId)
    {
        $result = new \stdClass();
        $result->metode_pemeriksaan = $sourceData->{'method_'.$parameterId.'_bottle_'.$bottleId} ?? null;
        $result->alat = $sourceData->{'equipment_'.$parameterId.'_bottle_'.$bottleId} ?? null;
        $result->reagen = null;
        $result->kualifikasi_pemeriksa = $sourceData->{'kualifikasi_pemeriksa_'.$parameterId.'_bottle_'.$bottleId} ?? null;
        $result->hasil = $sourceData->{'hasil_'.$parameterId.'_bottle_'.$bottleId} ?? null;
        return $result;
    }

    private function createHemostasisParameterStatisticTable($sourceData, $bottleId, $parameterId)
    {
        $result = new \stdClass();
        $result->metode_pemeriksaan = $sourceData->{'metode_'.$parameterId.'_bottle_'.$bottleId} ?? null;
        $result->alat = $sourceData->{'alat_'.$parameterId.'_bottle_'.$bottleId} ?? null;
        $result->reagen = $sourceData->{'reagen_'.$parameterId.'_bottle_'.$bottleId} ?? null;
        $result->kualifikasi_pemeriksa = $sourceData->{'kualifikasi_pemeriksa_'.$parameterId.'_bottle_'.$bottleId} ?? null;
        $result->hasil = $sourceData->{'hasil_'.$parameterId.'_bottle_'.$bottleId} ?? null;
        return $result;
    }

    private function createUrinalysisParameterStatisticTable($sourceData, $bottleId, $parameterId)
    {
        $result = new \stdClass();
        $result->metode_pemeriksaan = $sourceData->{'method_'.$parameterId.'_bottle_'.$bottleId} ?? null;
        $result->alat = $sourceData->{'equipment_'.$parameterId.'_bottle_'.$bottleId} ?? null;
        $result->reagen = $sourceData->{'reagen_'.$parameterId.'_bottle_'.$bottleId} ?? null;
        $result->kualifikasi_pemeriksa = $sourceData->{'kualifikasi_pemeriksa_'.$parameterId.'_bottle_'.$bottleId} ?? null;
        $result->hasil = $sourceData->{'hasil_pemeriksaan_'.$parameterId.'_bottle_'.$bottleId} ?? null;
        return $result;
    }

}
