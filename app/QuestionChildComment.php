<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionChildComment extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subComment()
    {
        return $this->hasMany(QuestionChildComment::class, 'parent_id');
    }
}
