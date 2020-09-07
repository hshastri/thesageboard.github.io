<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comment(){
        return $this->hasMany(Comment::class, 'answer_id');
    }

    public function total_vote_answer($answer_id){
        $upvote = Voting::where(['answer_id'=>$answer_id,'upvote'=>1])->count();
        $downvote = Voting::where(['answer_id'=>$answer_id,'downvote'=>1])->count();
        return $upvote - $downvote;
    }

    public function have_up_vote_answer($user_id,$answer_id){
        $reputaion =  Voting::where(['user_id'=>$user_id,'answer_id'=> $answer_id,'upvote'=>1])->count();
        $status="";
        if($reputaion){
            $status="active";
        }
        return $status;
    }

    public function have_down_vote_answer($user_id,$answer_id){
        $reputaion =  Voting::where(['user_id'=>$user_id,'answer_id'=> $answer_id,'downvote'=>1])->count();
        $status="";
        if($reputaion){
            $status="active";
        }
        return $status;
    }

    public function totalComment($ans_id){
        $answer = Comment::where('answer_id', $ans_id)->pluck('id')->toArray();
        $first_comment = Comment::whereIn('parent_id', $answer)->pluck('id')->toArray();
        $second_comment = Comment::whereIn('parent_id', $first_comment)->pluck('id')->toArray();
        return count($answer)+ count($first_comment)+ count($second_comment);
    }
}
