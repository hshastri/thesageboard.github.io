<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReferralTree extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class,'ref_user_id');
    }
}
