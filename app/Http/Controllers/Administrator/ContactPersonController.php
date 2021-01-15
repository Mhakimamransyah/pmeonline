<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginFromAdministratorRequest;
use App\Http\Requests\ShowParticipantRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactPersonController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'administrator']);
    }

    public function index()
    {
        return view('administrator.contact-person.index');
    }

    public function login(LoginFromAdministratorRequest $request)
    {
        Auth::logout();
        Auth::login($request->getUser());
        return redirect()->route('dashboard.participant')->with('success', __('Anda berhasil login sebagai ' . $request->getUser()->getName() . '.'));
    }

    public function show(ShowParticipantRequest $request)
    {
        return view('administrator.contact-person.show', [
            'user' => $request->getUser(),
        ]);
    }

    public function datatable(Request $request)
    {
        $start = $request->get('start');
        $length = $request->get('length');
        $page = ($start / $length) + 1;

        $searchQuery = $request->get('search')['value'];
        if ($searchQuery != null) {
            $users = User::query()->where('name', 'LIKE', '%'.$searchQuery.'%', 'or')
                ->where('email', 'LIKE', '%'.$searchQuery.'%', 'or')
                ->where('phone_number', 'LIKE', '%'.$searchQuery.'%', 'or')
                ->get();
        } else {
            $users = User::all();
        }

        $rawOrderQuery = $request->get('order');
        if ($rawOrderQuery != null && is_array($rawOrderQuery) && count($rawOrderQuery) >= 0) {
            $orderQuery = $rawOrderQuery[0];
            $orderBy = '';
            if (array_key_exists('column', $orderQuery)) {
                if ($orderQuery['column'] == '0') {
                    $orderBy = 'id';
                } else if ($orderQuery['column'] == '1') {
                    $orderBy = 'name';
                } else if ($orderQuery['column'] == '2') {
                    $orderBy = 'email';
                } else if ($orderQuery['column'] == '3') {
                    $orderBy = 'phone_number';
                }
                $users = $users->sortBy($orderBy, SORT_REGULAR, $orderQuery['dir'] == 'desc');
            }
        }

        $resultPerPage = $users->forPage($page, $length);
        $data = [];
        foreach ($resultPerPage as $resultItem) {
            array_push($data, [
                $resultItem->id, $resultItem->name ?? '-', $resultItem->email ?? '-', $resultItem->phone_number ?? '-',
            ]);
        }
        return [
            'draw' => $request->get('draw'),
            'recordsTotal' => User::count(),
            'recordsFiltered' => $users->count(),
            'data' => $data,
        ];
    }
}
