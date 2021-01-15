<?php

namespace App\Jobs;

use App\Concept\SubmitValue\Hematologi2019SubmitValue;
use App\Concept\SubmitValue\Hemostasis2019SubmitValue;
use App\Concept\SubmitValue\KimiaAir2019SubmitValue;
use App\Concept\SubmitValue\KimiaKlinik2019SubmitValue;
use App\Concept\SubmitValue\Urinalisa2019SubmitValue;
use App\v3\Cycle;
use App\v3\Order;
use App\v3\Submit;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Storage;

class CalculateScoreJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $cycle;

    public function __construct(Cycle $cycle)
    {
        $this->cycle = $cycle;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $packages = $this->cycle->packages()
            ->with(['parameters'])
            ->where('scoring_method', '!=', null)->get();
        $result = [];
        foreach ($packages as $package) {
            $submits = $package->orders()->get()->flatMap(function (Order $order) {
                return $order->submit()->with(['order', 'order.invoice', 'order.invoice.laboratory'])->get();
            })->filter(function (Submit $submit) use ($package) {
                if ($package->cycle_id <= 2) {
                    return $submit->sent;
                }
                return $submit->verified;
            });
            $submits = $submits->values();
            foreach ($submits as $submit) {
                if ($package->scoring_method == "kimia-klinik-2019") {
                    $submit->parsed = new KimiaKlinik2019SubmitValue($submit);
                }
                if ($package->scoring_method == "hematologi-2019") {
                    $submit->parsed = new Hematologi2019SubmitValue($submit);
                }
                if ($package->scoring_method == "urinalisa-2019") {
                    $submit->parsed = new Urinalisa2019SubmitValue($submit);
                }
                if ($package->scoring_method == "hemostasis-2019") {
                    $submit->parsed = new Hemostasis2019SubmitValue($submit);
                }
                if ($package->scoring_method == "kimia-air-2019") {
                    $submit->parsed = new KimiaAir2019SubmitValue($submit);
                }
                unset($submit->value);
                unset($submit->order->package);
            }
            $resultItem = new \stdClass();
            $resultItem->package = $package;

            $resultItem->least_items = 6;
            if ($package->scoring_method == "kimia-air-2019") {
                $resultItem->least_items = 0;
            }

            $resultItem->submits = $submits;
            array_push($result, $resultItem);
        }
        $str = json_encode($result);
        Storage::disk('local')->put('result-'.$this->cycle->id.'-'.time().'.json', $str);

        $client = new Client();
        $response = $client->postAsync('http://localhost:8080/auto-score', [
            'json' => $result,
        ]);
        $response->wait();
    }
}
