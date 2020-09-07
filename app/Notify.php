<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notify extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class , 'create_user_id');
    }

    public function question(){
        return $this->belongsTo(AskQuestion::class, 'question_id');
    }

}
