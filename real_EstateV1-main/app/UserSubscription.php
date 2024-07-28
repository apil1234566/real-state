<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class UserSubscription extends Model
{
    protected $guarded = [];

    public function hasExpired()
    {
        return Carbon::parse($this->end_date)->isPast();
    }
}
