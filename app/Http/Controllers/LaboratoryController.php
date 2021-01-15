<?php

namespace App\Http\Controllers;

use App\Cycle;
use App\Laboratory;
use App\LaboratoryOwnership;
use App\LaboratoryType;
use App\ProvinceFilter;
use Illuminate\Http\Request;

class LaboratoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'administrator']);
    }

    public function displayList()
    {
        return view('admin.laboratory.list', [
            'laboratories' => Laboratory::all(),
        ]);
    }

    public function filter(Request $request)
    {
        if ($request->isMethod('get')) {
            $result = array();
        }
        else if ($request->isMethod('post')) {
            $laboratoryType = $request->get('laboratory_type');
            $laboratoryOwnership = $request->get('laboratory_ownership');
            $provinceFilter = $request->get('province_filter');
            $result = Laboratory::all();
            if ($laboratoryType > 0) {
                $result = $result->where('laboratory_type_id', '=', $laboratoryType);
            }
            if ($laboratoryOwnership > 0) {
                $result = $result->where('laboratory_ownership_id', '=', $laboratoryOwnership);
            }
            if ($provinceFilter > 0) {
                $filter = ProvinceFilter::find($provinceFilter);
                if ($filter != null) {
                    $result = $result->where('province_id', '=', $filter->province->id);
                }
            }
            if ($provinceFilter == -2) {
                $filterNot = ProvinceFilter::all()->map(function ($item, $key) {
                    return $item->province->id;
                });
                $result = $result->whereNotIn('province_id', $filterNot);
            }
        }
        return view('admin.laboratory.filter', [
            'laboratory_types' => LaboratoryType::all(),
            'laboratory_ownerships' => LaboratoryOwnership::all(),
            'province_filters' => ProvinceFilter::all(),
            'cycles' => Cycle::all(),
            'laboratories' => $result,
            'laboratory_type_id' => $request->get('laboratory_type') ?: -1,
            'laboratory_ownership_id' => $request->get('laboratory_ownership') ?: -1,
            'province_filter_id' => $request->get('province_filter') ?: -1,
        ]);
    }
}
