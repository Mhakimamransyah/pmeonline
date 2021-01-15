<?php

namespace App\Http\Controllers\v5;

use App\Division;
use App\Http\Requests\CreateCycleRequest;
use App\Inject;
use App\v5\Invoice;
use App\v5\Cycle;
use App\v5\Order;
use App\v5\Package;
use App\v5\Payment;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class CycleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'administrator']);
    }

    public function indexDataTables(Request $request)
    {
        $start = $request->get('start');
        $length = $request->get('length');
        $page = ($start / $length) + 1;

        $data = Cycle::query()->get();
        $totalCount = $data->count();

        $searchQuery = $request->get('search')['value'];
        if ($searchQuery != null) {
            $data = $data->filter(function (Cycle $cycle) use ($searchQuery) {
                return Str::contains(strtolower($cycle->name), strtolower($searchQuery));
            });
        }

        $data = $data->map(function (Cycle $cycle) {
            $invoices = $cycle->packages()->get()->flatMap(function (Package $package) {
                return $package->orders()->get();
            })->flatMap(function (Order $order) {
                return $order->invoice()->get();
            });

            $participant_count = $invoices->filter(function (Invoice $invoice) {
                return $invoice->payment()->count() > 0 && in_array($invoice->payment->state, [Payment::STATE_DEBT, Payment::STATE_VERIFIED]);
            })->flatMap(function (Invoice $invoice) {
                return $invoice->laboratory()->get();
            })->unique()->count();

            $laboratories_count = $invoices->filter(function (Invoice $invoice) {
                return $invoice->payment()->count() > 0;
            })->flatMap(function (Invoice $invoice) {
                return $invoice->laboratory()->get();
            })->unique()->count();

            $obj = new \stdClass();
            $obj->id = $cycle->id;
            $obj->cycle_name = $cycle->name;
            $obj->register_count = $laboratories_count;
            $obj->participant_count = $participant_count;
            $obj->has_done = $cycle->has_done;
            $obj->has_not_started = $cycle->has_not_started;
            $obj->is_open_registration = $cycle->is_open_registration;
            $obj->is_open_submit = $cycle->is_open_submit;
            return $obj;
        });

        $cols = ['id', 'cycle_name', 'register_count', 'participant_count'];
        $rawOrderQuery = $request->get('order');
        if ($rawOrderQuery != null && is_array($rawOrderQuery) && count($rawOrderQuery) >= 0) {
            $orderQuery = $rawOrderQuery[0];
            if (array_key_exists('column', $orderQuery)) {
                $data = $data->sortBy($cols[$orderQuery['column']], SORT_REGULAR, $orderQuery['dir'] == 'desc');
            }
        }

        $filteredCount = $data->count();
        $data = $data->forPage($page, $length);

        return [
            'draw' => $request->get('draw'),
            'recordsTotal' => $totalCount,
            'recordsFiltered' => $filteredCount,
            'data' => $data->values(),
        ];
    }

    public function create(CreateCycleRequest $request)
    {
        $cycle = (new \App\Cycle)->fill($request->all());
        if ($cycle->errors()->isNotEmpty()) {
            return redirect()->back()->withErrors($cycle->errors())->withInput($request->all());
        }
        if (!$cycle->hasNotStarted()) {
            return redirect()->back()->withErrors(Collection::make('Siklus harus dibuat sebelum pendaftaran dibuka.'))->withInput($request->all());
        }
        $cycle->save();
        $packages = [
            [
                "name" => "pnpme-kk",
                "label" => "Kimia Klinik",
                "tariff" => 650000.0,
                "quota" => 1,
                "scoring_method" => "kimia-klinik-2019",
                "division" => "pathology",
                "template-options" => "pnpme-kk-3",
                "parameters" => [
                    [
                        "label" => "Bilirubin Total",
                        "unit" => "mg/dL¹",
                    ],
                    [
                        "label" => "Kolesterol",
                        "unit" => "mg/dL¹",
                    ],
                    [
                        "label" => "Kreatinin",
                        "unit" => "mg/dL¹",
                    ],
                    [
                        "label" => "Glukosa",
                        "unit" => "mg/dL¹",
                    ],
                    [
                        "label" => "Protein Total",
                        "unit" => "g/dL¹",
                    ],
                    [
                        "label" => "Ureum",
                        "unit" => "mg/dL¹",
                    ],
                    [
                        "label" => "Asam Urat",
                        "unit" => "mg/dL¹",
                    ],
                    [
                        "label" => "Trigliserida",
                        "unit" => "mg/dL¹",
                    ],
                    [
                        "label" => "GOT/ASAT",
                        "unit" => "U/L¹",
                    ],
                    [
                        "label" => "GPT/ALAT",
                        "unit" => "U/L¹",
                    ],
                    [
                        "label" => "Kalsium",
                        "unit" => "mg/dL¹",
                    ],
                    [
                        "label" => "Albumin",
                        "unit" => "g/dL¹",
                    ],
                    [
                        "label" => "Fosfatase Alkali",
                        "unit" => "U/L¹",
                    ],
                    [
                        "label" => "Gamma GT (GGT)",
                        "unit" => "U/L¹",
                    ],
                    [
                        "label" => "Natrium",
                        "unit" => "mEq/L",
                    ],
                    [
                        "label" => "Kalium",
                        "unit" => "mEq/L",
                    ],
                    [
                        "label" => "Chlorida",
                        "unit" => "mEq/L",
                    ],
                    [
                        "label" => "CK",
                        "unit" => "U/L",
                    ],
                    [
                        "label" => "CK-MB",
                        "unit" => "U/L",
                    ],
                    [
                        "label" => "Iron",
                        "unit" => null,
                    ],
                ],
            ],
            [
                "name" => "pnpme-hematologi",
                "label" => "Hematologi",
                "tariff" => 1110000.0,
                "quota" => 1,
                "scoring_method" => "hematologi-2019",
                "division" => "pathology",
                "template-options" => "pnpme-hematologi-3",
                "parameters" => [
                    [
                        "label" => "Hb",
                        "unit" => "g/dL",
                    ],
                    [
                        "label" => "Leukosit",
                        "unit" => "10³/µL",
                    ],
                    [
                        "label" => "Eritrosit",
                        "unit" => "10⁶/µL",
                    ],
                    [
                        "label" => "Hematokrit",
                        "unit" => "%",
                    ],
                    [
                        "label" => "MCV",
                        "unit" => "fL",
                    ],
                    [
                        "label" => "MCH",
                        "unit" => "pg",
                    ],
                    [
                        "label" => "MCHC",
                        "unit" => "g/dL",
                    ],
                    [
                        "label" => "Trombosit",
                        "unit" => "10³/µL",
                    ],
                ],
            ],
            [
                "name" => "pnpme-ur",
                "label" => "Urinalisa",
                "tariff" => 740000.0,
                "quota" => 1,
                "scoring_method" => "urinalisa-2019",
                "division" => "pathology",
                "template-options" => "pnpme-ur-3",
                "parameters" => [
                    [
                        "label" => "Berat Jenis",
                        "unit" => null,
                    ],
                    [
                        "label" => "PH",
                        "unit" => null,
                    ],
                    [
                        "label" => "Protein",
                        "unit" => null,
                    ],
                    [
                        "label" => "Glukosa",
                        "unit" => null,
                    ],
                    [
                        "label" => "Bilirubin",
                        "unit" => null,
                    ],
                    [
                        "label" => "Urobilinogen",
                        "unit" => null,
                    ],
                    [
                        "label" => "Darah",
                        "unit" => null,
                    ],
                    [
                        "label" => "Keton",
                        "unit" => null,
                    ],
                    [
                        "label" => "Nitrit",
                        "unit" => null,
                    ],
                    [
                        "label" => "Lekosit",
                        "unit" => null,
                    ],
                    [
                        "label" => "Tes Kehamilan",
                        "unit" => null,
                    ],
                ],
            ],
            [
                "name" => "pnpme-hemostatis",
                "label" => "Hemostasis",
                "tariff" => 510000.0,
                "quota" => 1,
                "scoring_method" => "hemostasis-2019",
                "division" => "pathology",
                "template-options" => "pnpme-hemostatis-3",
                "parameters" => [
                    [
                        "label" => "PT",
                        "unit" => "detik",
                    ],
                    [
                        "label" => "aPTT",
                        "unit" => "detik",
                    ],
                    [
                        "label" => "INR PT",
                        "unit" => "rasio",
                    ],
                    [
                        "label" => "Fibrinogen",
                        "unit" => "mg/dL",
                    ],
                ],
            ],
            [
                "name" => "pnpme-imunologi-antihiv",
                "label" => "Imunologi - Anti HIV",
                "tariff" => 575000.0,
                "quota" => 1,
                "scoring_method" => null,
                "division" => "immunology",
                "template-options" => "pnpme-imunologi-antihiv-3",
                "parameters" => [
                    [
                        "label" => "Anti HIV",
                        "unit" => null,
                    ],
                ],
            ],
            [
                "name" => "pnpme-imunologi-hbsag",
                "label" => "Imunologi - HBsAg",
                "tariff" => 470000.0,
                "quota" => 1,
                "scoring_method" => null,
                "division" => "immunology",
                "template-options" => "pnpme-imunologi-hbsag-3",
                "parameters" => [
                    [
                        "label" => "HBsAg",
                        "unit" => null,
                    ],
                ],
            ],
            [
                "name" => "pnpme-imunologi-antihcv",
                "label" => "Imunologi - Anti HCV",
                "tariff" => 550000.0,
                "quota" => 1,
                "scoring_method" => null,
                "division" => "immunology",
                "template-options" => "pnpme-imunologi-antihcv-3",
                "parameters" => [
                    [
                        "label" => "Anti HCV",
                        "unit" => null,
                    ],
                ],
            ],
            [
                "name" => "pnpme-imunologi-antitp",
                "label" => "Imunologi - TPHA",
                "tariff" => 550000.0,
                "quota" => 1,
                "scoring_method" => null,
                "division" => "immunology",
                "template-options" => "pnpme-imunologi-antitp-3",
                "parameters" => [
                    [
                        "label" => "TPHA",
                        "unit" => null,
                    ],
                ],
            ],
            [
                "name" => "pnpme-mikrobiologi-bta",
                "label" => "Mikrobiologi - BTA",
                "tariff" => 375000.0,
                "quota" => 1,
                "scoring_method" => null,
                "division" => "microbiology",
                "template-options" => "pnpme-mikrobiologi-bta-3",
                "parameters" => [
                    [
                        "label" => "BTA",
                        "unit" => null,
                    ],
                ],
            ],
            [
                "name" => "pnpme-mikrobiologi-malaria",
                "label" => "Mikrobiologi - Malaria",
                "tariff" => 375000.0,
                "quota" => 1,
                "scoring_method" => null,
                "division" => "microbiology",
                "template-options" => "pnpme-mikrobiologi-malaria-3",
                "parameters" => [
                    [
                        "label" => "Malaria",
                        "unit" => null,
                    ],
                ],
            ],
            [
                "name" => "pnpme-mikrobiologi-telurcacing",
                "label" => "Mikrobiologi - Parasit Saluran Pencernaan (Telur Cacing)",
                "tariff" => 317000.0,
                "quota" => 1,
                "scoring_method" => null,
                "division" => "microbiology",
                "template-options" => "pnpme-mikrobiologi-telurcacing-3",
                "parameters" => [
                    [
                        "label" => "Parasit Saluran Pencernaan (Telur Cacing)",
                        "unit" => null,
                    ],
                ],
            ],
            [
                "name" => "pnpme-mikrobiologi-kultur",
                "label" => "Mikrobiologi - Kultur dan Resistansi MO",
                "tariff" => 525000.0,
                "quota" => 1,
                "scoring_method" => null,
                "division" => "microbiology",
                "template-options" => "pnpme-mikrobiologi-kultur-3",
                "parameters" => [
                    [
                        "label" => "Kultur dan Resistansi MO",
                        "unit" => null,
                    ],
                ],
            ],
            [
                "name" => "pnpme-ka",
                "label" => "Kimia Air",
                "tariff" => 900000.0,
                "quota" => 1,
                "scoring_method" => "kimia-air-2019",
                "division" => "health-chemical",
                "template-options" => "pnpme-ka-3",
                "parameters" => [
                    [
                        "label" => "Alumunium",
                        "unit" => null,
                    ],
                    [
                        "label" => "Mangan",
                        "unit" => null,
                    ],
                    [
                        "label" => "Besi",
                        "unit" => null,
                    ],
                    [
                        "label" => "Zinc",
                        "unit" => null,
                    ],
                    [
                        "label" => "Tembaga",
                        "unit" => null,
                    ],
                ],
            ],
            [
                "name" => "pnpme-imunologi-rpr",
                "label" => "Imunologi - RPR",
                "tariff" => 550000.0,
                "quota" => 1,
                "scoring_method" => null,
                "division" => "immunology",
                "template-options" => "pnpme-imunologi-rpr-3",
                "parameters" => [
                    [
                        "label" => "RPR",
                        "unit" => null,
                    ],
                ],
            ],
        ];
        foreach ($packages as $packageData) {
            $package = (new \App\Package)->fill([
                "name" => $packageData["name"] . "-" . $cycle->id,
                "label" => $packageData["label"],
                "tariff" => $packageData["tariff"],
                "quota" => $packageData["quota"],
                "scoring_method" => $packageData["scoring_method"],
            ]);
            $package->cycle()->associate($cycle);
            $package->push();
            foreach ($packageData["parameters"] as $parameterData) {
                $parameter = (new \App\Parameter)->fill([
                    "label" => $parameterData["label"],
                    "unit" => $parameterData["unit"],
                ]);
                $parameter->package()->associate($package);
                $parameter->push();
            }
            $division = Division::query()->where("name", "=", $packageData["division"])->get()->first();
            if ($division != null) {
                $package->divisions()->attach($division->id);
            }
            File::copy(base_path("resources/views/templates/certificates/show/".$packageData["name"].".blade.php"), base_path("resources/views/certificates/show/".$package->name.".blade.php"));
            File::copy(base_path("resources/views/templates/form/components/".$packageData["name"].".blade.php"), base_path("resources/views/form/components/".$package->name.".blade.php"));
            File::copy(base_path("resources/views/templates/instalasi/statistic/components/".$packageData["name"].".blade.php"), base_path("resources/views/instalasi/statistic/components/".$package->name.".blade.php"));
            File::copy(base_path("resources/views/templates/preview/component/".$packageData["name"].".blade.php"), base_path("resources/views/preview/component/".$package->name.".blade.php"));
            File::copy(base_path("resources/views/templates/score/components/".$packageData["name"].".blade.php"), base_path("resources/views/score/components/".$package->name.".blade.php"));
            File::copy(base_path("resources/views/templates/scoring/components/".$packageData["name"].".blade.php"), base_path("resources/views/scoring/components/".$package->name.".blade.php"));

            $templatePackageName = $packageData["template-options"];
            error_log('$packageData["template-options"] : ' . $templatePackageName );
            $injects = \App\Package::query()->where('name', $templatePackageName)->first()->injects()->get();
            foreach ($injects as $inject) {
                $newInject = (new Inject);
                $newInject->option()->associate($inject->option);
                $newInject->package()->associate($package);
                $newInject->name = $inject->name;
                $newInject->save();
            }
        }
        return redirect()->back()->with(['success' => __('Siklus ' . $cycle->getName() . ' berhasil dibuat.')]);
    }

    public function delete(Cycle $cycle)
    {
        $cycle->delete();
        return redirect()->route('administrator.cycle.index');
    }
}
