<?php

namespace App\Http\Controllers;

use App\Submit;
use Illuminate\Http\Request;

class HotFixController extends Controller
{
    private function fixInvalidJsonDueToInvalidCut(Request $request)
    {
        $parameterMName = '';
        return Submit::query()->where('value', '!=', null)
            ->get()
            ->filter(function (Submit $submit) use ($parameterMName) {
                return $submit->order->package->name == $parameterMName;
            })
            ->each(function (Submit $submit) {
                $submit->value = substr($submit->value, 0, strrpos($submit->value, ',')) . '}';
                $submit->save();
            })
            ->values()
            ->toArray();
    }
}
