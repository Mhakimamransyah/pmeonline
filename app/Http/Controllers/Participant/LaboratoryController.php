<?php

namespace App\Http\Controllers\Participant;

use App\Http\Requests\ShowLaboratoryRequest;
use App\Http\Requests\UpdateLaboratoryRequest;
use App\Laboratory;
use App\LaboratoryOwnership;
use App\LaboratoryType;
use App\Province;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LaboratoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'participant']);
    }

    public function index()
    {
        $user = Auth::user();
        if (!$user instanceof User) { return abort(500); }
        return $this->indexLaboratories($user);
    }

    public function show(ShowLaboratoryRequest $request)
    {
        $user = Auth::user();
        if (!$user instanceof User) { return abort(500); }
        return $this->showLaboratory($request->getLaboratory(), $user);
    }

    public function update(UpdateLaboratoryRequest $request)
    {
        $user = Auth::user();
        if (!$user instanceof User) { return abort(500); }
        return $this->updateLaboratory($request, $user);
    }

    private function indexLaboratories(User $user)
    {
        return view('participant.laboratory.index', [
            'laboratories' => $user->getLaboratories(),
        ]);
    }

    private function showLaboratory(Laboratory $laboratory, User $user)
    {
        if (!$laboratory->getUser()->is($user)) {
            return abort(403);
        }
        return view('participant.laboratory.show', [
            'laboratory' => $laboratory,
            'optionsLaboratoryType' => LaboratoryType::all(),
            'optionsLaboratoryOwnership' => LaboratoryOwnership::all(),
            'optionsProvince' => Province::all(),
        ]);
    }

    private function updateLaboratory(UpdateLaboratoryRequest $request, User $user)
    {
        if (!$request->getLaboratory()->getUser()->is($user)) {
            return abort(403);
        }
        $request->getLaboratory()->fill($request->all())->save();
        return redirect()->back()->with(['success' => __('Detail instansi laboratorium berhasil diperbaharui.')]);
    }
}
