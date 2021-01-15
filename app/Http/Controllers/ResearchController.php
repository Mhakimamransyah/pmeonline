<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ResearchController extends Controller
{
    public function findAlg()
    {
        return view('v1.research.find-alg');
    }

    public function findAlgSubmit(Request $request)
    {
        $items = array();
        foreach (explode(' ', $request->get('items')) as $item) {
            array_push($items, (double) $item);
        }
        return $this->calculateAlg($items);
    }

    private function calculateAlg($items)
    {
        $client = new Client();
        $response = $client->request('POST', 'http://localhost:8522/find-algorithm-a', [
            'json' => [
                'items' => $items,
            ],
        ]);
        return redirect()->back()->with([
            'result' => json_decode($response->getBody()->getContents()),
            'items' => $items,
        ]);
    }
}
