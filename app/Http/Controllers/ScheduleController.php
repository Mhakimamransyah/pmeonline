<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{
    public function index()
    {
        // mengambil data dari tabel schedule
        $schedule = DB::table('schedules')->get();

        // mengirim data schedule ke view index
        return view('schedule', [
            'schedule' => $schedule
        ]);
    }
}
