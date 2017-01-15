<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Standard extends Model
{
    protected $guarded = [];

    public function scopeProposed($query)
    {
        return $query->whereNotNull('proposed_at');
    }
}
