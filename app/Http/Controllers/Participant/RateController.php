<?php

namespace App\Http\Controllers\Participant;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class RateController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'participant']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         // mengambil data dari tabel schedule
        $rate = DB::table('rates')->get();

        // mengirim data schedule ke view index
        return view('participant.rate.index', [
            'rate' => $rate
        ]);
    }

}
