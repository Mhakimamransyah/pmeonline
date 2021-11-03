<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Schedule;


class ScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'administrator']);
    }

    public function index()
    {
        // mengambil data dari tabel schedule
        $schedule = DB::table('schedules')->get();

        // mengirim data schedule ke view index
        return view('administrator.schedule.index', [
            'schedule' => $schedule
        ]);
    }

    public function create(Request $request)
    {
        $schedule = (new Schedule)
            ->fill($request->all());
       
        $schedule->save();
        return redirect()->back()->with(['success' => __('Jadwal berhasil di tambah')]);
    }

    // method untuk edit data pegawai
    public function edit($id)
    {
        // mengambil data pegawai berdasarkan id yang dipilih
        $schedule = DB::table('schedules')->where('id',$id)->get();
        // passing data pegawai yang didapat ke view edit.blade.php
        return view('administrator.schedule.edit', [
            'schedule' => $schedule
        ]);

    }

    public function update(Request $request)
    {
        // update data pegawai
        DB::table('schedules')->where('id',$request->id)->update([
            'kegiatan' => $request->kegiatan,
            'siklus_1' => $request->siklus_1,
            'siklus_2' => $request->siklus_2
        ]);
        // alihkan halaman ke halaman pegawai
        $schedule = DB::table('schedules')->get();
        return view('administrator.schedule.index', [
            'schedule' => $schedule
        ]);
    }

    public function hapus($id)
    {
        // menghapus data pegawai berdasarkan id yang dipilih
        DB::table('schedules')->where('id',$id)->delete();
            
        // alihkan halaman ke halaman pegawai
        // return redirect('/pegawai');
        return redirect()->back()->with(['success' => __('Jadwal berhasil di hapus')]);
    }
}
