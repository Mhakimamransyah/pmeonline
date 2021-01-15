<?php

namespace App\Http\Controllers\Installation;

use App\Http\Requests\ShowSubmitRequest;
use App\Order;
use App\Submit;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class SubmitController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'installation']);
    }

    public function index()
    {
        return view('instalasi.submit.index');
    }

    public function indexNull()
    {
        return view('instalasi.submit.index-null');
    }

    public function datatable(Request $request)
    {
        $start = $request->get('start');
        $length = $request->get('length');
        $page = ($start / $length) + 1;

        $orders = Order::query()->where('package_id', '=', $request->get('package_id'))->get();
        $submits = $orders->filter(function (Order $order) {
            return $order->invoice()->count() > 0 && $order->submit != null;
        })->map(function (Order $order) {
            return $order->submit;
        });

        $searchQuery = $request->get('search')['value'];
        $filtered = $submits;
        $filtered = $filtered->filter(function (Submit $submit) {
            return $submit->value != null;
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
            if ($submit->value == null) {
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

    public function show(ShowSubmitRequest $request)
    {
        return $this->showSubmit($request->getOrder());
    }

    private function showSubmit(Order $fromOrder)
    {
        if ($fromOrder->getInvoice() == null) {
            return abort(404);
        }
        $submit = Submit::query()->firstOrCreate([
            'order_id' => $fromOrder->getId()
        ]);
        if (!$submit instanceof Submit) {
            return abort(500);
        }
        if ($submit->value == null) {
            return redirect()->back()->withErrors(["Formulir isian ini belum pernah disimpan sebelumnya"]);
        }
        return view('preview.index', [
            'name' => $submit->getOrder()->getPackage()->getName(),
            'submit' => $submit,
            'value' => $submit->getValue(),
            'downloadLink' => route('installation.submit.download', ['order_id' => request()->get('order_id')]),
            'printLink' => route('installation.submit.print', ['order_id' => request()->get('order_id')]),
        ]);
    }

    public function datatableNull(Request $request)
    {
        $start = $request->get('start');
        $length = $request->get('length');
        $page = ($start / $length) + 1;

        $orders = Order::query()->where('package_id', '=', $request->get('package_id'))->get();
        $orders = $orders->filter(function (Order $order) {
            return $order->submit == null || $order->submit->value == null;
        });

        $searchQuery = $request->get('search')['value'];
        $filtered = $orders;
        $filtered = $filtered->filter(function (Order $order) {
            return $order->invoice()->count() > 0;
        });
        if ($searchQuery != null) {
            $searchQuery = strtolower($searchQuery);
            $filtered = $filtered->filter(function (Order $order) use ($searchQuery) {
                return (Str::contains($order->id, $searchQuery) ||
                    Str::contains(strtolower($order->laboratory_province), $searchQuery) ||
                    Str::contains(strtolower($order->participant_number), $searchQuery) ||
                    Str::contains(strtolower($order->laboratory_name), $searchQuery));
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

        foreach ($paginated as $order) {
            array_push($data, [
                $order->id,
                $order->laboratory_province,
                $order->participant_number,
                $order->laboratory_name,
                $order->order_id,
                'negative'
            ]);
        }

        return [
            'draw' => $request->get('draw'),
            'recordsTotal' => $paginated->count(),
            'recordsFiltered' => $sorted->count(),
            'data' => $data,
        ];
    }

    public function print(ShowSubmitRequest $request)
    {
        $submit = Submit::query()->firstOrCreate(['order_id' => $request->get('order_id')]);
        $view = view('print.index', [
            'name' => $submit->getOrder()->getPackage()->getName(),
        ]);
        $dompdf = new Dompdf();
        $dompdf->loadHtml($view);
        $dompdf->setPaper('A4', 'p');
        $dompdf->render();
        $dompdf->stream('Output PME - ' . time() . '.pdf', ['Attachment' => 0]);
    }

    public function download(ShowSubmitRequest $request)
    {
        $submit = Submit::query()->firstOrCreate(['order_id' => $request->get('order_id')]);
        $view = view('print.index', [
            'name' => $submit->getOrder()->getPackage()->getName(),
        ]);
        $dompdf = new Dompdf();
        $dompdf->loadHtml($view);
        $dompdf->setPaper('A4', 'p');
        $dompdf->render();
        $dompdf->stream('Output PME - ' . time() . '.pdf', ['Attachment' => 1]);
    }
}
