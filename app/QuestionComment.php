<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionComment extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function childComment(){
        return $this->hasMany(QuestionChildComment::class, 'comment_id');
    }


}
