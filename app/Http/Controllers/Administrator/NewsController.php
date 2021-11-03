<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\News;

class NewsController extends Controller
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
        $news = DB::table('news')->get();

        // mengirim data schedule ke view index
        return view('administrator.news.index', [
            'news' => $news
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $this->validate($request, [
            'title' => 'required',
			'gambar' => 'required|file|image|mimes:jpeg,png,jpg|max:2048',
            'body' => 'required',
            'active' => 'required'
		]);

        
        // menyimpan data file yang diupload ke variabel $file
		$file = $request->file('gambar');

		$nama_file = time()."_".$file->getClientOriginalName();

        // isi dengan nama folder tempat kemana file diupload
		$tujuan_upload = 'data_file';
		$file->move($tujuan_upload,$nama_file);
 
		News::create([
            'title' => $request->title,
			'gambar' => $nama_file,
			'body' => $request->body,
            'active' => $request->active,
		]);
        return redirect()->back()->with(['success' => __('Berita berhasil di tambah')]);
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
        $news = DB::table('news')->where('id',$id)->get();
        // passing data pegawai yang didapat ke view edit.blade.php
        return view('administrator.news.edit', [
            'news' => $news
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
        DB::table('news')->where('id',$request->id)->update([
            'title' => $request->title,
            'file' => $request->file,
            'body' => $request->body,
            'active' => $request->active
        ]);
        // alihkan halaman ke halaman pegawai
        $news = DB::table('news')->get();
        return view('administrator.news.index', [
            'news' => $news
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
        DB::table('news')->where('id',$id)->delete();
            
        // alihkan halaman ke halaman pegawai
        // return redirect('/pegawai');
        return redirect()->back()->with(['success' => __('Jadwal berhasil di hapus')]);
    }
}
