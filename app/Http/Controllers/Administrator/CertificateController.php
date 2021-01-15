<?php

namespace App\Http\Controllers\Administrator;

use App\Order;
use App\Submit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class CertificateController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'administrator']);
    }

    public function index()
    {
        return view('administrator.certificate.index');
    }

    public function datatable(Request $request)
    {
        $start = $request->get('start');
        $length = $request->get('length');
        $page = ($start / $length) + 1;

        $orders = Order::query()->where('package_id', '=', $request->get('package_id'))->get();
        $submits = $orders->filter(function (Order $order) {
            return $order->submit != null;
        })->map(function (Order $order) {
            return $order->submit;
        });

        $searchQuery = $request->get('search')['value'];
        $filtered = $submits;
        $filtered = $filtered->filter(function (Submit $submit) {
            return $submit->value != null && $submit->sent;
        });
        if ($searchQuery != null) {
            $searchQuery = strtolower($searchQuery);
            $filtered = $filtered->filter(function (Submit $submit) use ($searchQuery) {
                return (Str::contains($submit->id, $searchQuery) ||
                    Str::contains(strtolower($submit->laboratory_province), $searchQuery) ||
                    Str::contains(strtolower($submit->participant_number), $searchQuery) ||
                    Str::contains(strtolower($submit->laboratory_name), $searchQuery));
            });
        }

        $sorted = $filtered;
        $rawOrderQuery = $request->get('order');
        if ($rawOrderQuery != null && is_array($rawOrderQuery) && count($rawOrderQuery) >= 0) {
            $orderQuery = $rawOrderQuery[0];
            $orderBy = '';
            if (array_key_exists('column', $orderQuery)) {
                if ($orderQuery['column'] == '0') {
                    $orderBy = 'id';
                } else if ($orderQuery['column'] == '1') {
                    $orderBy = 'laboratory_province';
                } else if ($orderQuery['column'] == '2') {
                    $orderBy = 'participant_number';
                } else if ($orderQuery['column'] == '3') {
                    $orderBy = 'laboratory_name';
                } else if ($orderQuery['column'] == '4') {
                    $orderBy = 'id';
                }
                $sorted = $filtered->sortBy($orderBy, SORT_REGULAR, $orderQuery['dir'] == 'desc');
            }
        }


        $paginated = $sorted->forPage($page, $length);

        $data = [];

        foreach ($paginated as $submit) {
            if ($submit->score != null && $submit->score->value != null) {
                $state = 'blue';
            } else if ($submit->value == null) {
                $state = 'negative';
            } else if ($submit->verified) {
                $state = 'purple';
            } else if ($submit->sent) {
                $state = 'positive';
            } else {
                $state = 'warning';
            }

            array_push($data, [
                $submit->order->id,
                $submit->laboratory_province,
                $submit->participant_number,
                $submit->laboratory_name,
                $submit->order_id,
                $state
            ]);
        }

        return [
            'draw' => $request->get('draw'),
            'recordsTotal' => $paginated->count(),
            'recordsFiltered' => $sorted->count(),
            'data' => $data,
        ];
    }

    public function show(Request $request)
    {
        $submit = Submit::query()
            ->where('order_id', '=', $request->get('order_id'))
            ->get()
            ->first();
        return view('certificates.show.'.$submit->order->package->name, [
            'order' => $submit->order,
            'parameters' => $submit->selected_parameters,
        ]);
    }
}
