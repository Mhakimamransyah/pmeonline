<?php

namespace App\Http\Controllers\Participant;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class ScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'participant']);
    }

    public function index()
    {
        // mengambil data dari tabel schedule
        $schedule = DB::table('schedules')->get();

        // mengirim data schedule ke view index
        return view('participant.schedule.index', [
            'schedule' => $schedule
        ]);
    }
}
