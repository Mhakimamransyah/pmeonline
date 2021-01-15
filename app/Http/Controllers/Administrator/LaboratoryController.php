<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Requests\ShowLaboratoryRequest;
use App\Laboratory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LaboratoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'administrator']);
    }

    public function index()
    {
        return view('administrator.laboratory.index', [
            'laboratories' => Laboratory::all(),
        ]);
    }

    public function show(ShowLaboratoryRequest $request)
    {
        return view('administrator.laboratory.show', [
            'laboratory' => $request->getLaboratory(),
        ]);
    }

    public function updateParticipantNumber(Laboratory $laboratory, Request $request)
    {
        $laboratory->fill($request->all());
        $laboratory->save();
        return back()->with(['success' => 'Kode peserta berhasil disimpan']);
    }
}
