<?php

namespace App\Http\Controllers\Participant;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CertificateController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'participant']);
    }

    public function index()
    {
        return view('participant.certificate.index');
    }
}
