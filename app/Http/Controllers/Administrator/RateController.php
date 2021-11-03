<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Rate;

class RateController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'administrator']);
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
        return view('administrator.rate.index', [
            'rate' => $rate
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $rate = (new Rate)
            ->fill($request->all());
       
        $rate->save();
        return redirect()->back()->with(['success' => __('Tarif berhasil di tambah')]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // mengambil data pegawai berdasarkan id yang dipilih
        $rate = DB::table('rates')->where('id',$id)->get();
        // passing data pegawai yang didapat ke view edit.blade.php
        return view('administrator.rate.edit', [
            'rate' => $rate
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // update data pegawai
        DB::table('rates')->where('id',$request->id)->update([
            'bidang' => $request->bidang,
            'jmlsample' => $request->jmlsample,
            'parameter' => $request->parameter,
            'tarif' => $request->tarif
        ]);
        // alihkan halaman ke halaman pegawai
        $rate = DB::table('rates')->get();
        return view('administrator.rate.index', [
            'rate' => $rate
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         // menghapus data pegawai berdasarkan id yang dipilih
        DB::table('rates')->where('id',$id)->delete();
            
        // alihkan halaman ke halaman pegawai
        // return redirect('/pegawai');
        return redirect()->back()->with(['success' => __('Jadwal berhasil di hapus')]);
    }
}
