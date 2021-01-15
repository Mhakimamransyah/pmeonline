<?php

namespace App\Http\Controllers\Participant;

use App\Http\Requests\ShowSubmitRequest;
use App\Order;
use App\Submit;
use App\User;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SubmitController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'participant']);
    }

    public function index()
    {
        $user = Auth::user();
        if (!$user instanceof User) { return abort(500); }
        return $this->indexSubmitForm($user);
    }

    private function indexSubmitForm(User $user)
    {
        return view('participant.submit.index', [
            'orders' => $user->getOrdersAllowedToSubmit()
        ]);
    }

    public function show(ShowSubmitRequest $request)
    {
        $user = Auth::user();
        if (!$user instanceof User) { return abort(500); }
        return $this->showSubmit($request->getOrder(), $user);
    }

    private function showSubmit(Order $fromOrder, User $forUser)
    {
        if ($fromOrder->getInvoice() == null) {
            return abort(404);
        }
        if (!$fromOrder->getInvoice()->getLaboratory()->getUser()->is($forUser)) {
            return abort(403);
        }
        $submit = Submit::query()->firstOrCreate([
            'order_id' => $fromOrder->getId()
        ]);
        if (!$submit instanceof Submit) {
            return abort(500);
        }
        if ($submit->sent) {
            return view('preview.index', [
                'name' => $submit->getOrder()->getPackage()->getName(),
                'submit' => $submit,
                'value' => $submit->getValue(),
                'downloadLink' => route('participant.submit.download', ['order_id' => request()->get('order_id')]),
                'printLink' => route('participant.submit.print', ['order_id' => request()->get('order_id')]),
            ]);
        }
        return view('form.index', [
            'form' => $submit->getOrder()->getPackage()->getName(),
            'route' => route('participant.submit.save', ['order_id' => $fromOrder->id]),
            'submit' => $submit,
            'value' => $submit->getValue(),
            'package' => $submit->getOrder()->getPackage(),
        ]);
    }

    public function schedule()
    {
        $user = Auth::user();
        if (!$user instanceof User) { return abort(500); }
        return $this->checkEligibleToSubmit($user);
    }

    public function checkEligibleToSubmit(User $user)
    {
        return view('participant.submit.schedule', [
            'orders' => $user->getOrdersParticipated()
        ]);
    }

    public function save(Request $request)
    {
        $submit = Submit::query()->firstOrCreate(['order_id' => $request->get('order_id')]);
        $submit->value = json_encode($request->all());
        if ($request->has('send')) {
            $submit->sent = true;
        }
        $submit->save();
        if ($request->has('send')) {
            session()->flash('success', 'Berhasil terkirim');
        } else {
            session()->flash('success', 'Berhasil tersimpan');
        }
        return back();
    }

    public function preview(ShowSubmitRequest $request)
    {
        $user = Auth::user();
        if (!$user instanceof User) { return abort(500); }
        return $this->showPreview($request->getOrder(), $user);
    }

    public function showPreview(Order $fromOrder, User $forUser)
    {
        if ($fromOrder->getInvoice() == null) {
            return abort(404);
        }
        if (!$fromOrder->getInvoice()->getLaboratory()->getUser()->is($forUser)) {
            return abort(403);
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
            'downloadLink' => route('participant.submit.download', ['order_id' => request()->get('order_id')]),
            'printLink' => route('participant.submit.print', ['order_id' => request()->get('order_id')]),
        ]);
    }

    public function print(ShowSubmitRequest $request)
    {
        $submit = Submit::query()->firstOrCreate(['order_id' => $request->get('order_id')]);
        if ($submit->value == null) {
            return redirect()->back()->withErrors(["Formulir isian ini belum pernah disimpan sebelumnya"]);
        }
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
        if ($submit->value == null) {
            return redirect()->back()->withErrors(["Formulir isian ini belum pernah disimpan sebelumnya"]);
        }
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
