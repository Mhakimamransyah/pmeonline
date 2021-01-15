<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateLaboratoryRequest;
use App\Laboratory;
use App\LaboratoryOwnership;
use App\LaboratoryType;
use App\Order;
use App\OrderPackage;
use App\Participant;
use App\Province;
use App\Traits\ParticipantControllerTraits;
use App\Traits\SendMailTrait;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ParticipantController extends Controller
{
    use ParticipantControllerTraits, SendMailTrait;

    public function __construct()
    {
        $administratorMethods = ['filterParticipantsByCycle'];
        $this->middleware(['auth', 'participant'])->except($administratorMethods);
        $this->middleware(['auth', 'administrator'])->only($administratorMethods);
    }

    public function showReceiptConfirmation()
    {
        return view('participant.receipt-confirmation');
    }

    public function showTechnicalNotes()
    {
        return view('participant.technical-notes');
    }

    public function showPostResult()
    {
        // Todo : also filter by cycle
        $approvedOrders = Participant::all()->filter(function ($item) {
            $order = Order::findOrFail($item->order_id);
            $laboratory = Laboratory::findOrFail($order->laboratory_id);
            return $laboratory->contact_person_id == $this->findContactPerson()->id;
        })->map(function ($item) {
            return Order::findOrFail($item->order_id);
        });
        if ($approvedOrders != null && $approvedOrders->count() > 0) {
            return view('participant.form-list', [
                'approvedOrders' => $approvedOrders,
            ]);
        }
        return view('participant.pending-participant');
    }

    public function showReports()
    {
        return view('soon');
    }

    public function showCertificates()
    {
        return view('soon');
    }

    public function filterParticipantsByCycle(Request $request)
    {
        $cycleId = $request->get('cycle') ?: 1;
        $participants = Participant::all()->filter(function ($item) use ($cycleId) {
            return $item->siklus() == $cycleId;
        });

        $filterByTypeId = $request->get('type') ?: -1;
        if ($filterByTypeId != -1) {
            $participants = $participants->filter(function ($item) use ($filterByTypeId) {
                return $item->laboratoryType()->id == $filterByTypeId;
            });
        }

        $filterByOwnershipId = $request->get('ownership') ?: -1;
        if ($filterByOwnershipId != -1) {
            $participants = $participants->filter(function ($item) use ($filterByOwnershipId) {
                return $item->laboratoryOwnership()->id == $filterByOwnershipId;
            });
        }

        $filterByProvinceId = $request->get('province_filter') ?: -1;
        if ($filterByProvinceId > 0) {
            $participants = $participants->filter(function ($item) use ($filterByProvinceId) {
                if ($item->provinceFilter() != null) {
                    return $item->provinceFilter()->id == $filterByProvinceId;
                }
                return false;
            });
        }
        if ($filterByProvinceId == -2) {
            $participants = $participants->filter(function ($item) use ($filterByProvinceId) {
                return $item->provinceFilter() == null;
            });
        }

        $filterByPackageId = $request->get('package') ?: -1;
        if ($filterByPackageId != -1) {
            $participants = $participants->filter(function ($item) use ($filterByPackageId) {
                $packagesFilterId = $item->packagesFilter()->map(function ($item) {
                    return $item->id;
                })->all();
                return in_array($filterByPackageId, $packagesFilterId);
            });
        }

        return view('admin.participant.filter', [
            'type_id' => $filterByTypeId,
            'ownership_id' => $filterByOwnershipId,
            'province_filter_id' => $request->get('province_filter') ?: -1,
            'cycle_id' => $cycleId,
            'package_id' => $filterByPackageId,
            'participants' => $participants,
        ]);
    }

    public function showForm($id)
    {
        $orderPackage = OrderPackage::findOrFail($id);
        if ($orderPackage->order->laboratory->contactPerson->id != $this->findContactPerson()->id) {
            return abort(403);
        }
        $form = $orderPackage->package->form;
        if ($form->table_name != null) {
            DB::table($form->table_name)->updateOrInsert([
                'order_package_id' => $id,
            ], [
                'created_at' => new Carbon(),
            ]);
            $result = DB::table($form->table_name)->where(['order_package_id' => $id])->get()->first();
            if ($result->sent == 1) {
                return redirect()->route('participant.post-result.preview', ['id' => $id]);
            }
            return view('form.' . $form->name, [
                'order_package_id' => $id,
                'filled_form' => $result,
            ]);
        }
        return view('form.' . $form->name, [
            'order_package_id' => $id,
        ]);
    }

    public function showPreview($id)
    {
        $orderPackage = OrderPackage::findOrFail($id);
        if ($orderPackage->order->laboratory->contactPerson->id != $this->findContactPerson()->id) {
            return abort(403);
        }
        $form = $orderPackage->package->form;
        if ($form->table_name != null) {
            DB::table($form->table_name)->updateOrInsert([
                'order_package_id' => $id,
            ], [
                'created_at' => new Carbon(),
            ]);
            $result = DB::table($form->table_name)->where(['order_package_id' => $id])->get()->first();
            return view('preview.' . $form->name, [
                'order_package_id' => $id,
                'filled_form' => $result,
            ]);
        }
        return view('preview.' . $form->name, [
            'order_package_id' => $id,
        ]);
    }
}
