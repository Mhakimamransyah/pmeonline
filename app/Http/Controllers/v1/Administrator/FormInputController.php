<?php

namespace App\Http\Controllers\v1\Administrator;

use App\FormInput;
use App\OrderPackage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FormInputController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'administrator']);
    }

    public function index(Request $request)
    {
        $orderPackage = OrderPackage::find($request->get('order_package_id'));
        return view('v1.administrator.form-input.index', [
            'orderPackage' => $orderPackage,
        ]);
    }

    public function send(Request $request)
    {
        $formInput = FormInput::where('order_package_id', '=', $request->get('order_package_id'))->first();
        $formInput->sent = $request->get('send');
        $formInput->save();
        return redirect()->back();
    }
}
