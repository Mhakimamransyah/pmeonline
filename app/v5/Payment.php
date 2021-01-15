<?php

namespace App\v5;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    const STATE_WAITING = 'waiting';

    const STATE_VERIFIED = 'verified';

    const STATE_REJECTED = 'rejected';

    const STATE_DEBT = 'debt';

    public function invoice()
    {
        return $this->hasOne('App\Invoice');
    }
}
