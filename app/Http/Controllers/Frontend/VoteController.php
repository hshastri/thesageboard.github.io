<?php

namespace App\Http\Controllers\Frontend;

use App\Answer;
use App\AskQuestion;
use App\BasicSetting;
use App\ChatRoom;
use App\Http\Controllers\Controller;
use App\Http\Controllers\EmailController;
use App\Notify;
use App\Payments;
use App\ReferralPayment;
use App\ReferralTree;
use App\Reputation;
use App\User;
use App\UserDetails;
use App\Voting;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Str;

class VoteController extends Controller
{
    public function vote_question($id, $type){
        $previous = 0;
        $vote =   Voting::where(['user_id'=> Auth::user()->id, 'question_id'=> base64_decode($id)]);
        $update_vote = $vote->first();
        if($update_vote){
            if($type=='up'){
                $downvote = $vote->where('downvote',1)->first();
                if($downvote){
                    $previous = 2;
                    $update_vote->upvote = 1;
                    $update_vote->downvote = 0;
                }else{
                    return 0;
                }
            }else{
                $upvote = $vote->where('upvote',1)->first();
                if($upvote){
                    $previous = 1;
                    $update_vote->upvote = 0;
                    $update_vote->downvote = 1;
                }else{
                    return 0;
                }
            }
            if($update_vote->save()){
                $this->calculate_reputaion_question_vote(base64_decode($id), $type, $previous);
                $total_vote = $this->get_total_voting_question(base64_decode($id));
                return [1, $total_vote];
            }
            return 0;
        }else{
            $voteing = new Voting();
            $voteing->user_id = Auth::user()->id;
            $voteing->question_id =  base64_decode($id);
            if($type=='up'){
                $voteing->upvote = 1;
            }else{
                $voteing->downvote = 1;
            }
            if( $voteing->save()){
                $this->calculate_reputaion_question_vote(base64_decode($id), $type, $previous);
                $total_vote = $this->get_total_voting_question(base64_decode($id));
                return [1, $total_vote];
            }
            return 0;
        }
    }


    public function get_total_voting_question($id){
        $upvote = Voting::where(['question_id'=>$id,'upvote'=>1])->count();
        $downvote = Voting::where(['question_id'=>$id,'downvote'=>1])->count();
        $total = $upvote - $downvote;

        $askQuestion = AskQuestion::where('id',$id)->first();
        $askQuestion->totalvote = $total;
        $askQuestion->save();
        return sign_vote($total);
    }


    public function vote_answer($id, $type){
        $previous=0;
        $vote =   Voting::where(['user_id'=> Auth::user()->id, 'answer_id'=> base64_decode($id)]);
        $answeer = Answer::where(['user_id'=> Auth::user()->id, 'id'=> base64_decode($id)])->first();
        if($answeer){
            return 3;
        }
        $update_vote = $vote->first();
        if($update_vote){
            if($type=='up'){
                $downvote = $vote->where('downvote',1)->first();
                if($downvote){
                    $previous=2;
                    $update_vote->upvote = 1;
                    $update_vote->downvote = 0;
                }else{
                    return 0;
                }
            }else{
                $upvote = $vote->where('upvote',1)->first();
                if($upvote){
                    $previous=1;
                    $update_vote->upvote = 0;
                    $update_vote->downvote = 1;
                }else{
                    return 0;
                }
            }
            if($update_vote->save()){
                $this->calculate_reputaion_answer_vote(base64_decode($id) ,$type,$previous);
                $total_vote = $this->get_total_voting_answer(base64_decode($id));
                return [1, $total_vote];
            }
            return 0;
        }else{
            $voteing = new Voting();
            $voteing->user_id = Auth::user()->id;
            $voteing->answer_id =  base64_decode($id);
            if($type=='up'){
                $voteing->upvote = 1;
            }else{
                $voteing->downvote = 1;
            }
            if( $voteing->save()){
                $this->calculate_reputaion_answer_vote(base64_decode($id) ,$type,$previous);
                $total_vote = $this->get_total_voting_answer(base64_decode($id));
                return [1, $total_vote];
            }
            return 0;
        }
    }

    public function get_total_voting_answer($id){
        $upvote = Voting::where(['answer_id'=>$id,'upvote'=>1])->count();
        $downvote = Voting::where(['answer_id'=>$id,'downvote'=>1])->count();
        return sign_vote($upvote - $downvote);
    }


    public function vote_comment($id, $type){
        $vote =   Voting::where(['user_id'=> Auth::user()->id, 'comment_id'=> base64_decode($id)]);
        $update_vote = $vote->first();
        if($update_vote){
            if($type=='up'){
                $downvote = $vote->where('downvote',1)->first();
                if($downvote){
                    $update_vote->upvote = 1;
                    $update_vote->downvote = 0;
                }else{
                    return 0;
                }
            }else{
                $upvote = $vote->where('upvote',1)->first();
                if($upvote){
                    $update_vote->upvote = 0;
                    $update_vote->downvote = 1;
                }else{
                    return 0;
                }
            }
            if($update_vote->save()){
                return [1, $type];
            }
            return 0;
        }else{
            $voteing = new Voting();
            $voteing->user_id = Auth::user()->id;
            $voteing->comment_id =  base64_decode($id);
            if($type=='up'){
                $voteing->upvote = 1;
            }else{
                $voteing->downvote = 1;
            }
            if( $voteing->save()){
                return [1, $type];
            }
            return 0;
        }
    }

    public function calculate_reputaion_question_vote($id, $type , $previous){
        $upvote = 0;
        $downvote = 0;

        $ask_question = AskQuestion::where('id',$id)->first();
        $user_deatils = UserDetails::where('user_id', $ask_question->user_id)->first();

        if($ask_question->question_label=='General'){
            $upvote = BasicSetting::where('key', 'general_question_up_vote_score')->first();
            $downvote = BasicSetting::where('key', 'general_question_down_vote_score')->first();
        }else{
            $upvote = BasicSetting::where('key', 'premium_question_up_vote_score')->first();
            $downvote = BasicSetting::where('key', 'premium_question_down_vote_score')->first();
        }

        if($type=='up'){
            $value = Str::limit($ask_question->question_title, 50);
            $this->notifyComment($id,$ask_question->user_id,$value,'9');
            if($ask_question->question_label=='General'){
                $current_score_g=0;
                if($previous==1){
                    $current_score =  $user_deatils->general_reputation_score-$upvote->value;
                }elseif($previous==2){
                    $current_score_g =  $user_deatils->general_reputation_score+$downvote->value;
                }else{
                    $current_score_g =  $user_deatils->general_reputation_score;
                }
                $user_deatils->general_reputation_score = $current_score_g+$upvote->value;
            }else{
                $current_score_p=0;
                if($previous==1){
                    $current_score_p =  $user_deatils->expert_reputation_score-$upvote->value;
                }elseif($previous==2){
                    $current_score_p =  $user_deatils->expert_reputation_score+$downvote->value;
                }else{
                    $current_score_p =  $user_deatils->expert_reputation_score;
                }
                $user_deatils->expert_reputation_score = $current_score_p+$upvote->value;
            }
        }else{
            if($ask_question->question_label=='General'){
                $current_score_g=0;
                if($previous==1){
                    $current_score_g =  $user_deatils->general_reputation_score-$upvote->value;
                }elseif($previous==2){
                    $current_score_g =  $user_deatils->general_reputation_score+$downvote->value;
                }else{
                    $current_score_g =  $user_deatils->general_reputation_score;
                }

                $user_deatils->general_reputation_score = $current_score_g-$downvote->value;
            }else{
                $current_score_p=0;
                if($previous==1){
                    $current_score_p =  $user_deatils->expert_reputation_score-$upvote->value;
                }elseif($previous==2){
                    $current_score_p =  $user_deatils->expert_reputation_score+$downvote->value;
                }else{
                    $current_score_p =  $user_deatils->expert_reputation_score;
                }
                $user_deatils->expert_reputation_score = $current_score_p-$downvote->value;
            }
        }

        $user_deatils->save();
        $this->calculate_tags_point_question($ask_question->user_id,$ask_question->tags, $ask_question->question_label ,$type,$previous);

        return true;
    }

    public function calculate_reputaion_answer_vote($id, $type,$previous){
        $upvote = 0;
        $downvote = 0;

        $answer = Answer::where('id',$id)->first();
        $ask_question = AskQuestion::where('id',$answer->question_id)->first();
        $user_deatils = UserDetails::where('user_id', $answer->user_id)->first();

        if($ask_question->question_label=='General'){
            $upvote = BasicSetting::where('key', 'general_answer_up_vote_score')->first();
            $downvote = BasicSetting::where('key', 'general_answer_down_vote_score')->first();
        }else{
            $upvote = BasicSetting::where('key', 'premium_answer_up_vote_score')->first();
            $downvote = BasicSetting::where('key', 'premium_answer_down_vote_score')->first();
        }

        if($type=='up'){

            $value = Str::limit($answer->answer, 50);
            $this->notifyComment($answer->question_id,$answer->user_id,$value,'11');

            if($ask_question->question_label=='General'){
                $current_score_p = 0;
                if($previous==1){
                    $current_score_p =  $user_deatils->general_reputation_score-$upvote->value;
                }elseif($previous==2){
                    $current_score_p =  $user_deatils->general_reputation_score+$downvote->value;
                }else{
                    $current_score_p =  $user_deatils->general_reputation_score;
                }
                $user_deatils->general_reputation_score = $current_score_p+$upvote->value;
            }else{
                $current_score_p = 0;
                if($previous==1){
                    $current_score_p =  $user_deatils->expert_reputation_score-$upvote->value;
                }elseif($previous==2){
                    $current_score_p =  $user_deatils->expert_reputation_score+$downvote->value;
                }else{
                    $current_score_p =  $user_deatils->expert_reputation_score;
                }
                $user_deatils->expert_reputation_score = $current_score_p+$upvote->value;
            }
        }else{
            if($ask_question->question_label=='General'){
                $current_score_p = 0;
                if($previous==1){
                    $current_score_p =  $user_deatils->general_reputation_score-$upvote->value;
                }elseif($previous==2){
                    $current_score_p =  $user_deatils->general_reputation_score+$downvote->value;
                }else{
                    $current_score_p =  $user_deatils->general_reputation_score;
                }
                $user_deatils->general_reputation_score = $current_score_p-$downvote->value;
            }else{
                $current_score_p = 0;
                if($previous==1){
                    $current_score_p =  $user_deatils->expert_reputation_score-$upvote->value;
                }elseif($previous==2){
                    $current_score_p =  $user_deatils->expert_reputation_score+$downvote->value;
                }else{
                    $current_score_p =  $user_deatils->expert_reputation_score;
                }
                $user_deatils->expert_reputation_score = $current_score_p-$downvote->value;
            }
        }
        $user_deatils->save();
        $this->calculate_tags_point_answer($answer->user_id,$ask_question->tags, $ask_question->question_label ,$type,$previous);
        return true;
    }

    public function calculate_tags_point_question($user_id, $tags, $question_label, $vote_type,$previous){
        $upvote=0;
        $downvote=0;
        $tags = explode(',', $tags);

        if($question_label=='General'){
            $upvote = BasicSetting::where('key', 'general_question_up_vote_score')->first();
            $downvote = BasicSetting::where('key', 'general_question_down_vote_score')->first();
        }else{
            $upvote = BasicSetting::where('key', 'premium_question_up_vote_score')->first();
            $downvote = BasicSetting::where('key', 'premium_question_down_vote_score')->first();
        }

        $upvote = $upvote->value/count($tags);
        $downvote = $downvote->value/count($tags);


        foreach ($tags as $key=> $value){
            $reputation = Reputation::where('user_id',$user_id)->where('tag','Like','%'.$value.'%')->orWhere('tag','Like','%'.$value.'s%')->first();
            if($reputation){
                $current_score = 0;
                if($previous==1){
                    $current_score =  $reputation->point-$upvote;
                }elseif($previous==2){
                    $current_score =  $reputation->point+$downvote;
                }else{
                    $current_score =  $reputation->point;
                }

                if($vote_type=='up'){
                    $reputation->point = $current_score + $upvote;
                }else{
                    $reputation->point = $current_score - $downvote;
                }
                $reputation->save();
            }else{
                $new_repu = new Reputation();
                $new_repu->user_id = $user_id;
                $new_repu->tag = $value;
                if($vote_type=='up'){
                    $new_repu->point = $new_repu->point + $upvote;
                }else{
                    $new_repu->point = $new_repu->point - $downvote;
                }
                $new_repu->save();
            }
        }
        return true;
    }

    public function calculate_tags_point_answer($user_id, $tags, $question_label, $vote_type, $previous){
        $upvote=0;
        $downvote=0;
        $tags = explode(',', $tags);
        if($question_label=='General'){
            $upvote = BasicSetting::where('key', 'general_answer_up_vote_score')->first();
            $downvote = BasicSetting::where('key', 'general_answer_down_vote_score')->first();
        }else{
            $upvote = BasicSetting::where('key', 'premium_answer_up_vote_score')->first();
            $downvote = BasicSetting::where('key', 'premium_answer_down_vote_score')->first();
        }
        $upvote = $upvote->value/count($tags);
        $downvote = $downvote->value/count($tags);

        foreach ($tags as $key=> $value){
            $reputation = Reputation::where('user_id',$user_id)->where('tag','Like','%'.$value.'%')->orWhere('tag','Like','%'.$value.'s%')->first();
            if($reputation){
                $current_score = 0;
                if($previous==1){
                    $current_score =  $reputation->point-$upvote;
                }elseif($previous==2){
                    $current_score =  $reputation->point+$downvote;
                }else{
                    $current_score =  $reputation->point;
                }

                if($vote_type=='up'){
                    $reputation->point =$current_score + $upvote;
                }else{
                    $reputation->point = $current_score - $downvote;
                }
                $reputation->save();
            }else{
                $new_repu = new Reputation();
                $new_repu->user_id = $user_id;
                $new_repu->tag = $value;
                if($vote_type=='up'){
                    $new_repu->point = $new_repu->point + $upvote;
                }else{
                    $new_repu->point = $new_repu->point - $downvote;
                }

                $new_repu->save();
            }
        }
        return true;
    }

    public function accepted_answer($answerid){
        $answers = Answer::where('id', base64_decode($answerid))->first();
        $answers->accepted = 'yes';
        $answers->save();

        $ask_question = AskQuestion::where('id',$answers->question_id)->first();
        $ask_question->isSolved = 'yes';
        $ask_question->save();

        $user_deatils = UserDetails::where('user_id', $answers->user_id)->first();
        $user_deatils->general_reputation_score = $user_deatils->general_reputation_score+30;
        $user_deatils->save();

        $tags = explode(',', $ask_question->tags);
        $tagpoint = 30/count($tags);
        foreach ($tags as $key=> $value) {
            $reputation = Reputation::where('user_id', $answers->user_id)->where('tag', 'Like', '%' . $value . '%')->orWhere('tag', 'Like', '%' . $value . 's%')->first();
            if ($reputation) {
                $reputation->point = $reputation->point+$tagpoint;
                $reputation->save();
            }else{
                $new_repu = new Reputation();
                $new_repu->user_id = $answers->user_id;
                $new_repu->tag = $value;
                $new_repu->point = $tagpoint;
                $new_repu->save();
            }
        }

        $value = Str::limit($ask_question->question_title, 50);
        $this->notifyComment($answers->question_id , $answers->user_id, $value , 4);

        $emails = new EmailController();
        $emails->acceptPublicAnswer($answers->user_id , $answers->question_id , base64_decode($answerid));

        return 1;
    }


    public function private_accepted_answer($qid, $eid, $cid){

        $answers = Answer::where('question_id', base64_decode($qid))->first();
        $answers->accepted = 'yes';
        $answers->type = '1';
        $answers->save();

        $ask_question = AskQuestion::where('id',base64_decode($qid))->first();
        $ask_question->isSolved = 'yes';
        $ask_question->save();

        $expert_payment = Payments::where(['expert_id'=>base64_decode($eid), 'question_id'=> base64_decode($qid)])->first();
        $expert_payment->status= 'Earnings';
        $expert_payment->save();

        $user_deatils = UserDetails::where('user_id', base64_decode($eid))->first();
        $user_deatils->expert_reputation_score = $user_deatils->expert_reputation_score+30;
        $user_deatils->balance = $user_deatils->balance+$expert_payment->amount;
        $user_deatils->save();

        $chat_room = ChatRoom::where('unicode', $cid)->first();
        $chat_room->accepted = "yes";
        $chat_room->save();

        $this->addReferalBalance($eid,$qid);

        $tags = explode(',', $ask_question->tags);
        $tagpoint = 30/count($tags);
        foreach ($tags as $key=> $value) {
            $reputation = Reputation::where('user_id', $user_deatils->user_id)->where('tag', 'Like', '%' . $value . '%')->orWhere('tag', 'Like', '%' . $value . 's%')->first();
            if ($reputation) {
                $reputation->point = $reputation->point+$tagpoint;
                $reputation->save();
            }else{
                $new_repu = new Reputation();
                $new_repu->user_id = $user_deatils->user_id;
                $new_repu->tag = $value;
                $new_repu->point = $tagpoint;
                $new_repu->save();
            }
        }

        $value = Str::limit($ask_question->question_title, 50);
        $this->notifyComment($ask_question->id , base64_decode($eid), $value , 5);

        $this->notifyComment($ask_question->id , base64_decode($eid), $value , 7);

        $emails = new EmailController();
        $emails->acceptPrivateAnswer(base64_decode($eid) , $expert_payment->amount);

        return 1;
    }

    public function addReferalBalance($eid , $qid){
        /*Here user id is expert user id*/
        $expert_payment = Payments::where(['status'=>'Cost', 'question_id'=> base64_decode($qid)])->first();
        $question_id= base64_decode($qid);
        $comission = BasicSetting::where('key','comission')->first();
        $rate = ($expert_payment->amount*$comission->value)/100;
       /* $immidiateUserCost = .6;
        $secondUserCost = .3;
        $thirdUserCost = .015;*/

        $immidiateUserCost = .2;
        $secondUserCost = .1;
        $thirdUserCost = .05;

        $imidiate = ReferralTree::where('ref_user_id', base64_decode($eid))->first();
        if($imidiate){
            $b1= $rate*$immidiateUserCost;
            $user_deatils_one = UserDetails::where('user_id', $imidiate->user_id)->first();
            $user_deatils_one->balance = $user_deatils_one->balance+$b1;
            $user_deatils_one->save();

            $this->addRefferTransaction($b1,$imidiate->user_id,base64_decode($eid));

            $secondUser = ReferralTree::where('ref_user_id',$imidiate->user_id)->first();
            if($secondUser){
                $b2= $rate*$secondUserCost;
                $user_deatils_two = UserDetails::where('user_id', $secondUser->user_id)->first();
                $user_deatils_two->balance = $user_deatils_two->balance+$b2;
                $user_deatils_two->save();

                $this->addRefferTransaction($b2,$secondUser->user_id,base64_decode($eid));

                $thirdUser = ReferralTree::where('ref_user_id',$secondUser->user_id)->first();
                if($thirdUser){
                    $b3 = $rate*$thirdUserCost;
                    $user_deatils_three = UserDetails::where('user_id', $thirdUser->user_id)->first();
                    $user_deatils_three->balance = $user_deatils_three->balance+$b3;
                    $user_deatils_three->save();

                    $this->addRefferTransaction($b3,$thirdUser->user_id,base64_decode($eid));
                }
            }
        }
        return true;
    }

    public function addRefferTransaction($amount, $user,$e_id){

        $pya_reffer =new ReferralPayment();
        $pya_reffer->payment_uid=Str::random(20);
        $pya_reffer->amount=$amount;
        $pya_reffer->expert_id=$e_id;
        $pya_reffer->user_id=$user;
        $pya_reffer->payerID=Auth::user()->id;
        $pya_reffer->save();
        return true;
    }

    public function notifyComment($qid , $notifyUser , $title , $type){
        $not =  new Notify();
        $not->create_user_id = Auth::user()->id;
        $not->question_id = $qid;
        $not->notify_user_id = $notifyUser;
        $not->notify_title = $title;
        $not->type = $type;
        $not->save();
    }

}
