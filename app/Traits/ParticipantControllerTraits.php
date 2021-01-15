<?php

namespace App\Traits;

use App\ContactPerson;
use Illuminate\Support\Facades\Auth;

trait ParticipantControllerTraits
{

    /**
     * Get contact person from current user.
     *
     * @return ContactPerson
     */
    public function findContactPerson()
    {
        return $contactPerson = ContactPerson::where('user_id', '=', Auth::user()->id)->first();
    }
}