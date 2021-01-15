<?php

namespace App\Http\Controllers;

use App\Cycle;
use App\Division;
use App\Package;
use App\Role;
use App\Submit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubmitController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        if ($user->role->division != null) {
            return $this->indexForDivision($user->role->division, $request);
        }
        if ($user->role->name == Role::ROLE_PARTICIPANT) {
            return $this->indexForParticipant($request);
        }
        if ($user->role->name == Role::ROLE_ADMIN) {
            return $this->indexForAdmin($request);
        }
        return abort(401);
    }

    private function indexForDivision(Division $division, Request $request)
    {
        if ($request->has('package_id')) {
            $submits = Submit::all()->filter(function (Submit $submit) use ($request) {
                return $submit->order->package->id == $request->get('package_id');
            });
            return view('submits.role.admin-and-division.index.submits', [
                'submits' => $submits,
            ]);
        }
        if ($request->has('cycle_id')) {
            $packages = Package::query()
                ->where('cycle_id', '=', $request->get('cycle_id'))
                ->whereIn('id', $division->packages->map(function (Package $package) {
                    return $package->id;
                }))
                ->get();
            return view('submits.role.admin-and-division.index.packages', [
                'packages' => $packages,
            ]);
        }
        return view('submits.role.admin-and-division.index.cycles', [
            'cycles' => Cycle::all(),
        ]);
    }

    private function indexForParticipant(Request $request)
    {
        //
    }

    private function indexForAdmin(Request $request)
    {
        if ($request->has('package_id')) {
            $submits = Submit::all()->filter(function (Submit $submit) use ($request) {
                return $submit->order->package->id == $request->get('package_id');
            });
            return view('submits.role.admin-and-division.index.submits', [
                'submits' => $submits,
            ]);
        }
        if ($request->has('cycle_id')) {
            $packages = Package::query()
                ->where('cycle_id', '=', $request->get('cycle_id'))
                ->get();
            return view('submits.role.admin-and-division.index.packages', [
                'packages' => $packages,
            ]);
        }
        return view('submits.role.admin-and-division.index.cycles', [
            'cycles' => Cycle::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $submit = Submit::findOrFail($id);
        $user = Auth::user();
        if ($user->role->division != null) {
            return $this->showForDivision($user->role->division, $submit);
        }
        if ($user->role->name == Role::ROLE_PARTICIPANT) {
            return $this->showForParticipant($submit);
        }
        if ($user->role->name == Role::ROLE_ADMIN) {
            return $this->showForAdmin($submit);
        }
        return abort(401);
    }

    private function showForDivision(Division $division, Submit $submit)
    {
        $submit->computed_value = json_decode($submit->value);
        return view('preview.'.$submit->order->package->name, [
            'submit' => $submit,
        ]);
    }

    private function showForParticipant(Submit $submit)
    {
        $submit->computed_value = json_decode($submit->value);
        return $submit;
    }

    private function showForAdmin(Submit $submit)
    {
        $submit->computed_value = json_decode($submit->value);
        return $submit;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
