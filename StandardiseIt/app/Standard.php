<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Standard extends Model
{
    protected $guarded = [];

    public function scopeProposed($query)
    {
        return $query->whereNotNull('proposed_at');
    }

    public function propose()
    {
        $this->proposed_at = Carbon::now();
    }

    public function isProposed()
    {
        return ! is_null($this->proposed_at);
    }
}
