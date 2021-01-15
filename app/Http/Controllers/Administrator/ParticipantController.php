<?php

namespace App\Http\Controllers\Administrator;

use App\Cycle;
use App\Laboratory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ParticipantController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'administrator']);
    }

    public function index()
    {
        return view('administrator.participant.index', [
            'optionCycles' => Cycle::all(),
        ]);
    }

    public function datatable(Request $request)
    {
        $start = $request->get('start');
        $length = $request->get('length');
        $page = ($start / $length) + 1;

        $cycleId = $request->get('cycle');
        if ($cycleId == null) {
            return [
                'draw' => $request->get('draw'),
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
            ];
        }
        $cycle = Cycle::query()->findOrFail($cycleId);

        $participantsCount = $cycle->participants->count();

        $searchQuery = $request->get('search')['value'];
        if ($searchQuery != null) {
            $participants = $cycle->filterParticipants($searchQuery);
        } else {
            $participants = $cycle->participants;
        }

        $rawOrderQuery = $request->get('order');
        if ($rawOrderQuery != null && is_array($rawOrderQuery) && count($rawOrderQuery) >= 0) {
            $orderQuery = $rawOrderQuery[0];
            $orderBy = '';
            if (array_key_exists('column', $orderQuery)) {
                if ($orderQuery['column'] == '0') {
                    $orderBy = 'participant_number';
                } else if ($orderQuery['column'] == '1') {
                    $orderBy = 'name';
                }
                $participants = $participants->sortBy($orderBy, SORT_REGULAR, $orderQuery['dir'] == 'desc');
            }
        }

        $resultPerPage = $participants->forPage($page, $length);
        $data = [];
        foreach ($resultPerPage as $resultItem) {
            array_push($data, [
                $resultItem->participant_number ?? '-', $resultItem->name ?? '-', $resultItem->id,
            ]);
        }

        return [
            'draw' => $request->get('draw'),
            'recordsTotal' => $participantsCount,
            'recordsFiltered' => $participants->count(),
            'data' => $data,
        ];
    }
}
