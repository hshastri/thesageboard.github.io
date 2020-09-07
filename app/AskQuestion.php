<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AskQuestion extends Model
{

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function subcategory(){
        return $this->belongsTo(SubCategory::class);
    }

    public function payment(){
        return $this->hasMany(PaymentDetails::class, 'question_id');
    }

    public function answer(){
        return $this->hasMany(Answer::class, 'question_id');
    }

    public function questionComment(){
        return $this->hasMany(QuestionComment::class, 'question_id');
    }

    public function total_vote($question_id){
        $upvote = Voting::where(['question_id'=>$question_id,'upvote'=>1])->count();
        $downvote = Voting::where(['question_id'=>$question_id,'downvote'=>1])->count();
        return $upvote - $downvote;
    }

    public function have_up_vote_question($user_id,$question_id){
       $reputaion =  Voting::where(['user_id'=>$user_id,'question_id'=> $question_id,'upvote'=>1])->count();
       $status="";
       if($reputaion){
           $status="active";
       }
       return $status;
    }

    public function have_down_vote_question($user_id,$question_id){
        $reputaion =  Voting::where(['user_id'=>$user_id,'question_id'=> $question_id,'downvote'=>1])->count();
        $status="";
        if($reputaion){
            $status="active";
        }
        return $status;
    }

    public function totalComment($qsn_id){
        $answer = QuestionComment::where('question_id', $qsn_id)->pluck('id')->toArray();
        $first_comment = QuestionChildComment::whereIn('comment_id', $answer)->pluck('id')->toArray();
        $second_comment = QuestionChildComment::whereIn('parent_id', $first_comment)->pluck('id')->toArray();
        return count($answer)+ count($first_comment)+ count($second_comment);
    }




}
