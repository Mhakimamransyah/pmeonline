<?php

namespace App\Http\Controllers;

use App\v3\Score;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AutoScoreController extends Controller
{

    public function result(Request $request)
    {
        Storage::disk('local')->put('result-debug-'.time().'.json', json_encode($request->all()));
        foreach ($request->json()->all() as $resultItem) {
            $orderIds = Collection::make($resultItem['segment']['submits'])->map(function ($submit) {
                return $submit['order']['id'];
            })->all();
            foreach ($orderIds as $orderId) {
                $score = Score::firstOrNew(['order_id' => $orderId]);
                $score->value = json_encode($resultItem['calculatedParameters']);
                $score->save();
            }
        }
    }
}
