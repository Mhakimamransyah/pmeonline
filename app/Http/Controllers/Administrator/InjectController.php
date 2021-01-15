<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateInjectRequest;
use App\Http\Requests\UpdateInjectRequest;
use App\Inject;
use App\Option;
use App\Package;
use Illuminate\Http\Request;

class InjectController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'administrator']);
    }

    public function index(Request $request)
    {
        $items = [];
        if ($request->has('package_id')) {
            $package = Package::findOrFail($request->get('package_id'));
            $items = $package->injects;
        }
        return view('administrator.inject.index', [
            'injects' => $items,
            'options' => Option::all(),
        ]);
    }

    public function store(CreateInjectRequest $request)
    {
        $inject=  new Inject();
        $inject->fill($request->all());
        $inject->save();
        return back()->with(['success' => 'Berhasil tersimpan']);
    }

    public function show(Inject $inject)
    {
        return view('administrator.inject.show', [
            'inject' => $inject,
            'options' => Option::all(),
        ]);
    }

    public function update(UpdateInjectRequest $request, Inject $inject)
    {
        $inject->fill($request->all());
        $inject->save();
        return back()->with(['success' => 'Berhasil tersimpan']);
    }

    public function destroy(Inject $inject)
    {
        //
    }
}
