<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Exceptions\StateTransitionNotAllowed;

class Standard extends Model
{
    protected $guarded = [];

    public function scopeProposed($query)
    {
        return $query->whereNotNull('proposed_at');
    }

    public function propose()
    {
        if ($this->isProposed()) {
            throw new StateTransitionNotAllowed();
        }

        $this->proposed_at = Carbon::now();
        $this->save();
    }

    public function isProposed()
    {
        return ! is_null($this->proposed_at);
    }
}
