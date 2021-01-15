<?php

namespace App\Http\Controllers;

use App\Traits\ParticipantControllerTraits;
use Illuminate\Http\Request;

class InstructionController extends Controller
{
    use ParticipantControllerTraits;

    public function __construct()
    {
        $administratorMethods = [
            'displayAsAdministrator'
        ];
        $this->middleware(['auth', 'participant'])->except($administratorMethods);
        $this->middleware(['auth', 'administrator'])->only($administratorMethods);
    }

    public function displayAsAdministrator()
    {
        return view('admin.instruction.display');
    }
}
