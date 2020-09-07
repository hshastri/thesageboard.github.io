<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function question()
    {
        return $this->belongsTo(AskQuestion::class,'question_id');
    }

    public function expert()
    {
        return $this->belongsTo(User::class,'expert_id');
    }
}
