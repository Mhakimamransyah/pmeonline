<?php

namespace App\Http\Controllers;

use App\FormInput;
use App\OrderPackage;
use App\Traits\CreateCarbonTrait;
use App\Traits\ImploderTrait;
use App\Traits\ParticipantControllerTraits;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FormController extends Controller
{
    use ParticipantControllerTraits, ImploderTrait, CreateCarbonTrait;

    public function __construct()
    {
        $administratorMethods = [
            'inputByAdministrator', 'proceedByAdmin', 'proceedMikrobiologiMalariaFormByAdmin', 'showPreviewByaAdministrator'
        ];
        $this->middleware(['auth', 'participant'])->except($administratorMethods);
        $this->middleware(['auth', 'administrator'])->only($administratorMethods);
    }

    public function proceedMikrobiologiMalariaForm($order_package_id, Request $request)
    {
        $table_name = OrderPackage::findOrFail($order_package_id)->package->form->table_name;
        $sent = $request->get('sent') == '1';
        $update = DB::table($table_name)->updateOrInsert(
            [
                'order_package_id' => $order_package_id,
            ], [
                'bahan_kontrol' => $request->get('bahan_kontrol'),
                'tanggal_penerimaan' => $this->createCarbon($request->get('tanggal_penerimaan')),
                'tanggal_pemeriksaan' => $this->createCarbon($request->get('tanggal_pemeriksaan')),
                'kondisi_bahan' => $request->get('kondisi_bahan'),
                'deskripsi_kondisi_bahan' => $request->get('deskripsi_kondisi_bahan'),
                'kode_0' => $request->get('kode-0'),
                'kode_1' => $request->get('kode-1'),
                'kode_2' => $request->get('kode-2'),
                'kode_3' => $request->get('kode-3'),
                'kode_4' => $request->get('kode-4'),
                'kode_5' => $request->get('kode-5'),
                'kode_6' => $request->get('kode-6'),
                'kode_7' => $request->get('kode-7'),
                'kode_8' => $request->get('kode-8'),
                'kode_9' => $request->get('kode-9'),
                'hasil_0' => $this->imploder($request->get('hasil-0')),
                'hasil_1' => $this->imploder($request->get('hasil-1')),
                'hasil_2' => $this->imploder($request->get('hasil-2')),
                'hasil_3' => $this->imploder($request->get('hasil-3')),
                'hasil_4' => $this->imploder($request->get('hasil-4')),
                'hasil_5' => $this->imploder($request->get('hasil-5')),
                'hasil_6' => $this->imploder($request->get('hasil-6')),
                'hasil_7' => $this->imploder($request->get('hasil-7')),
                'hasil_8' => $this->imploder($request->get('hasil-8')),
                'hasil_9' => $this->imploder($request->get('hasil-9')),
                'saran' => $request->get('saran'),
                'nama_pemeriksa' => $request->get('nama_pemeriksa'),
                'kualifikasi_pemeriksa' => $request->get('kualifikasi_pemeriksa'),
                'sent' => $sent,
            ]
        );
        if ($request->get('save_and_preview') == '1') {
            return redirect(route('participant.post-result.preview', ['id' => $order_package_id]));
        }
        if ($update) {
            return redirect()->back()->with([
                'success' => 'Tersimpan.'
            ]);
        } else {
            return redirect()->back()->with([
                'error' => 'Data gagal tersimpan.'
            ]);
        }
    }

    public function proceedMikrobiologiMalariaFormByAdmin($order_package_id, Request $request)
    {
        $table_name = OrderPackage::findOrFail($order_package_id)->package->form->table_name;
        $sent = $request->get('sent') == '1';
        $update = DB::table($table_name)->updateOrInsert(
            [
                'order_package_id' => $order_package_id,
            ], [
                'bahan_kontrol' => $request->get('bahan_kontrol'),
                'tanggal_penerimaan' => $this->createCarbon($request->get('tanggal_penerimaan')),
                'tanggal_pemeriksaan' => $this->createCarbon($request->get('tanggal_pemeriksaan')),
                'kondisi_bahan' => $request->get('kondisi_bahan'),
                'deskripsi_kondisi_bahan' => $request->get('deskripsi_kondisi_bahan'),
                'kode_0' => $request->get('kode-0'),
                'kode_1' => $request->get('kode-1'),
                'kode_2' => $request->get('kode-2'),
                'kode_3' => $request->get('kode-3'),
                'kode_4' => $request->get('kode-4'),
                'kode_5' => $request->get('kode-5'),
                'kode_6' => $request->get('kode-6'),
                'kode_7' => $request->get('kode-7'),
                'kode_8' => $request->get('kode-8'),
                'kode_9' => $request->get('kode-9'),
                'hasil_0' => $this->imploder($request->get('hasil-0')),
                'hasil_1' => $this->imploder($request->get('hasil-1')),
                'hasil_2' => $this->imploder($request->get('hasil-2')),
                'hasil_3' => $this->imploder($request->get('hasil-3')),
                'hasil_4' => $this->imploder($request->get('hasil-4')),
                'hasil_5' => $this->imploder($request->get('hasil-5')),
                'hasil_6' => $this->imploder($request->get('hasil-6')),
                'hasil_7' => $this->imploder($request->get('hasil-7')),
                'hasil_8' => $this->imploder($request->get('hasil-8')),
                'hasil_9' => $this->imploder($request->get('hasil-9')),
                'saran' => $request->get('saran'),
                'nama_pemeriksa' => $request->get('nama_pemeriksa'),
                'kualifikasi_pemeriksa' => $request->get('kualifikasi_pemeriksa'),
                'sent' => $sent,
            ]
        );
        if ($request->get('save_and_preview') == '1') {
            return redirect()->back()->with([
                'success' => 'Tersimpan.'
            ]);
//            return redirect(route('participant.post-result.preview', ['id' => $order_package_id]));
        }
        if ($update) {
            return redirect()->back()->with([
                'success' => 'Tersimpan.'
            ]);
        } else {
            return redirect()->back()->with([
                'error' => 'Data gagal tersimpan.'
            ]);
        }
    }

    public function proceed($order_package_id, Request $request)
    {
        $table_name = OrderPackage::findOrFail($order_package_id)->package->form->table_name;
        $update = DB::table($table_name)->updateOrInsert([
            'order_package_id' => $order_package_id,
        ], [
            'value' => json_encode($request->all()),
        ]);
        if ($request->get('save_and_preview') == '1') {
            return redirect(route('participant.post-result.preview', ['id' => $order_package_id]));
        }
        if ($request->get('sent') == '1') {
            return $this->sent($order_package_id);
        }
        if ($update) {
            return redirect()->back()->with([
                'success' => 'Tersimpan.'
            ]);
        } else {
            return redirect()->back()->with([
                'error' => 'Data gagal tersimpan.'
            ]);
        }
    }

    public function proceedByAdmin($order_package_id, Request $request)
    {
        $table_name = OrderPackage::findOrFail($order_package_id)->package->form->table_name;
        $update = DB::table($table_name)->updateOrInsert([
            'order_package_id' => $order_package_id,
        ], [
            'value' => json_encode($request->all()),
        ]);
        if ($request->has('berkas_pendukung')) {
            $berkas_pendukung = $request->file('berkas_pendukung');
            foreach ($berkas_pendukung as $file) {
                Storage::putFile('berkas_pendukung', $file);
            }
        }
        if ($request->get('save_and_preview') == '1') {
            return $this->sent($order_package_id);
//            return redirect(route('participant.post-result.preview', ['id' => $order_package_id]));
        }
        if ($request->get('sent') == '1') {
            return $this->sent($order_package_id);
        }
        if ($update) {
            return redirect()->back()->with([
                'success' => 'Tersimpan.'
            ]);
        } else {
            return redirect()->back()->with([
                'error' => 'Data gagal tersimpan.'
            ]);
        }
    }

    private function sent($id)
    {
        $form = FormInput::where('order_package_id', '=', $id)->first();
        $form->sent = 1;
        $form->save();
        return redirect()->back()->with([
            'success', 'Terkirim.'
        ]);
    }

    public function inputByAdministrator($id)
    {
        $orderPackage = OrderPackage::findOrFail($id);
        $form = $orderPackage->package->form;
        if ($form->table_name != null) {
            DB::table($form->table_name)->updateOrInsert([
                'order_package_id' => $id,
            ], [
                'created_at' => new Carbon(),
            ]);
            $result = DB::table($form->table_name)->where(['order_package_id' => $id])->get()->first();
            return view('form.' . $form->name, [
                'order_package_id' => $id,
                'filled_form' => $result,
            ]);
        }
        return view('form.' . $form->name, [
            'order_package_id' => $id,
        ]);
    }

    public function showPreviewByaAdministrator($id)
    {
        $orderPackage = OrderPackage::findOrFail($id);
        $form = $orderPackage->package->form;
        if ($form->table_name != null) {
            DB::table($form->table_name)->updateOrInsert([
                'order_package_id' => $id,
            ], [
                'created_at' => new Carbon(),
            ]);
            $result = DB::table($form->table_name)->where(['order_package_id' => $id])->get()->first();
            return view('preview.' . $form->name, [
                'order_package_id' => $id,
                'filled_form' => $result,
            ]);
        }
        return view('preview.' . $form->name, [
            'order_package_id' => $id,
        ]);
    }

}
