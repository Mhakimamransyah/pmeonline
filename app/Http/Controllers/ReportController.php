<?php

namespace App\Http\Controllers;

use App\LittleFlower\FormInputParser;
use App\LittleFlower\StatisticController;
use App\OrderPackage;
use App\ScoreInput;
use App\Traits\ContactPersonSurveyAnswerTrait;
use App\Traits\ParticipantControllerTraits;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class ReportController extends Controller
{
    use ParticipantControllerTraits, ContactPersonSurveyAnswerTrait;

    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware(['participant'])->only(['indexParticipant', 'showAsParticipant']);
    }

    /**
     * Index certificates as contact person / participant.
     *
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexParticipant(Request $request)
    {
        $laboratories = $this->findContactPerson()->laboratories()->with(['orders', 'orders.cycle', 'orders.orderPackages', 'orders.orderPackages.package.subject', 'orders.orderPackages.package.display'])->get();
        if ($request->has('order_package')) {
            return $this->showAsParticipant($request->get('order_package'), $laboratories, $request);
        }
        $data = [
            'laboratories' => $laboratories
        ];
        if ($request->has('debug')) {
            return $data;
        }
        return view('report.index', ['data' => $data]);
    }

    /**
     * Show certificate as contact person / participant.
     *
     * @param string $orderPackageId
     * @param Collection $laboratories
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    private function showAsParticipant(string $orderPackageId, Collection $laboratories, Request $request)
    {
        if (!$this->checkIfContactPersonHasAnswerSurvey($laboratories[0]->contact_person_id)) {
            return redirect()->route('participant.survey.show-form', ['id' => 1])->with('warning', '<b>Survey.</b> Mohon meluangkan waktu untuk mengisi survey yang telah disediakan. Masukkan Anda sangat berarti bagi kami.');
        }
        if ($this->checkOwnership($orderPackageId, $laboratories)) {
            return $this->show($orderPackageId, $request);
        } else {
            throw new UnauthorizedHttpException('Unauthorized action.');
        }
    }

    /**
     * Check if the laboratories are the owner of the certificate.
     *
     * @param string $orderPackageId
     * @param Collection $laboratories
     * @return bool
     */
    private function checkOwnership(string $orderPackageId, Collection $laboratories)
    {
        $orderPackages = $laboratories->map(function ($item) {
            return $item->orders[0];
        })->first()->toArray()['order_packages'];
        $orderPackages = Collection::make($orderPackages)->map(function ($item) {
            return $item['id'];
        })->toArray();
        return in_array($orderPackageId, $orderPackages);
    }

    /**
     * Show report.
     *
     * @param string $orderPackageId
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    private function show(string $orderPackageId, Request $request)
    {
        $orderPackage = OrderPackage::with(['package', 'package.subject'])->findOrFail($orderPackageId);
        if (in_array($orderPackage->package->id, [1, 2, 3, 4])) {
            return $this->showPatologi($orderPackage, $request->get('bottle'), $request);
        }
        if (in_array($orderPackage->package->id, [13])) {
            return $this->showKesehatan($orderPackage);
        }
        $scoreInput = $orderPackage->scoreInput;
        if ($scoreInput == null) {
            return redirect()->back()->withErrors('Penilaian belum dilakukan.');
        }
        return $this->showGeneral($scoreInput->id);
    }

    /**
     * Show general report.
     *
     * @param $scoreInputId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showGeneral($scoreInputId)
    {
        $score_input = ScoreInput::findOrFail($scoreInputId);
        $orderPackage = OrderPackage::findOrFail($score_input->order_package_id);
        $form = $orderPackage->package->form;
        if ($form->table_name != null) {
            $result = DB::table($form->table_name)->where(['order_package_id' => $score_input->order_package_id])->get()->first();
            return view('score.' . $form->name, [
                'order_package_id' => $score_input->order_package_id,
                'filled_form' => $result,
                'score' => json_decode($score_input->value),
            ]);
        } else {
            throw new NotFoundHttpException();
        }
    }

    /**
     * Show patologi report.
     *
     * @param $orderPackage
     * @param $bottle_id
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showPatologi($orderPackage, $bottle_id, Request $request)
    {
        $form = $orderPackage->package->form;
        $form_input_id = DB::table($form->table_name)->where(['order_package_id' => $orderPackage->id])->get()->first()->id;

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
            throw new NotFoundHttpException();
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
            'order_package_id' => $orderPackage->id,
            'result' => json_encode($item),
            'bottle_number' => $bottle_id + 1,
            'bottle_string' => $bottle_string,
        ]);
    }

    /**
     * Show kimia kesehatan report.
     *
     * @param $orderPackage
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showKesehatan($orderPackage)
    {
        ini_set('max_execution_time', 300); // 5 minutes

        $form = $orderPackage->package->form;
        $form_input_id = DB::table($form->table_name)->where(['order_package_id' => $orderPackage->id])->get()->first()->id;

        $client = new Client();
        $result = $client->request('GET', env('SCORING_URL') . '/form-input/' . $form_input_id, [
            'query' => [
                'bottle_id' => '0'
            ]
        ])->getBody();
        return view('score.pnpme-ka', ['score' => $result, 'order_package_id' => $orderPackage->id]);
    }
}
