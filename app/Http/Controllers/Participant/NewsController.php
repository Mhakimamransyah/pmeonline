<?php

namespace App\Http\Controllers\Participant;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class NewsController extends Controller
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
        var_dump("<pre>");
        var_dump("wkwk");
        die();

        // mengambil data dari tabel schedule
        $news = DB::table('news')->get();

        // mengirim data schedule ke view index
        return view('participant.home', [
            'news' => $news
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    
}
