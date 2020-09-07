<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentDetails extends Model
{
    public function title($id){
        $title = AskQuestion::where('payment_id',$id)->first();
        return $title['question_title'];
    }

    public function expert_list($id){
        $expert_list = AskQuestion::where('payment_id',$id)->first();
        return $expert_list['experties_ids'];
    }

    public function author($id, $type){
        $author = AskQuestion::where('payment_id',$id)->first();
        $user = User::where('id', $author['user_id'])->first();
        if($type=="name"){
            $name = $user['first_name'] ." ". $user['last_name'];
            return $name;
        }
        if($type=="email"){
            $email = $user['email'];
            return $email;
        }


    }
}
