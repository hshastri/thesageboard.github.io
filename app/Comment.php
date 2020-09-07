<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function total_vote_comment($comment_id){
        $upvote = Voting::where(['comment_id'=>$comment_id,'upvote'=>1])->count();
        $downvote = Voting::where(['comment_id'=>$comment_id,'downvote'=>1])->count();
        return $upvote - $downvote;
    }
}
