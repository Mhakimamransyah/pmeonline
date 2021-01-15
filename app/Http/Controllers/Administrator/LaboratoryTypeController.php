<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Requests\CreateLaboratoryTypeRequest;
use App\Http\Requests\UpdateLaboratoryTypeRequest;
use App\LaboratoryType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LaboratoryTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'administrator']);
    }

    public function index()
    {
        return view('administrator.option.laboratory-type.index', [
            'laboratoryTypes' => LaboratoryType::all(),
        ]);
    }

    public function create(CreateLaboratoryTypeRequest $request)
    {
        $item = (new LaboratoryType)
            ->fill($request->all());
        $item->save();
        return redirect()->back()->with(['success' => __('Tipe instansi ' . $item->getName() . ' berhasil ditambah.')]);
    }

    public function show(Request $request)
    {
        return view('administrator.option.laboratory-type.show', [
            'laboratoryType' => LaboratoryType::query()->findOrFail($request->get('id')),
        ]);
    }

    public function update(UpdateLaboratoryTypeRequest $request)
    {
        $item = $request->getLaboratoryType()->fill($request->except('id'));
        $item->save();
        return redirect()->route('administrator.option.laboratory-type.index')->with(['success' => __('Tipe instansi ' . $item->getName() . ' berhasil diperbaharui.')]);
    }

}
