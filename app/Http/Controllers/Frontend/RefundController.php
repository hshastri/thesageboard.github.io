<?php

namespace App\Http\Controllers\Frontend;
use App\AskQuestion;
use App\BasicSetting;
use App\ChatRoom;
use App\Http\Controllers\Controller;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\PaypalController;
use App\Payments;
use App\Refund;
use App\UserDetails;
use Illuminate\Http\Request;
use Auth;
class RefundController extends Controller
{
    public function index(){
        $payments = Refund::where('user_id',Auth::user()->id)->paginate(8);
        return view('frontend.user.wallet.refund', compact("payments"));
    }

    public function make_refund(Request $request,$qid,$eid){
        if(!$_POST){
            $ramount = Payments::where(['user_id'=>Auth::user()->id,'expert_id'=>base64_decode($eid),'question_id'=>base64_decode($qid)])->value('amount');
            return view('frontend.partial.refund_modal', compact("qid",'eid','ramount'));
        }else{

            $chat_room = ChatRoom::where(['question_id'=>base64_decode($qid),'user_two_id'=>base64_decode($eid) ,'user_one_id'=>Auth::user()->id])->first();
            $chat_room->accepted = "reject";
            $chat_room->save();

            $user_deatils = UserDetails::where('user_id', base64_decode($eid))->first();
            $user_deatils->expert_reputation_score = $user_deatils->expert_reputation_score-12;
            $user_deatils->save();

            $emails = new EmailController();
            $emails->declinePrivateAnswer(base64_decode($eid) , base64_decode($qid));

            $hasrefund = Refund::where(['question_id'=>base64_decode($qid),'expert_id'=>base64_decode($eid)])->first();
            if($hasrefund){
                flash('Refund Request Already Send')->success();
                return back();
            }
            $refund =new Refund();
            $refund->question_id = base64_decode($qid);
            $refund->expert_id = base64_decode($eid);
            $refund->user_id = Auth::user()->id;
            $refund->payment_id = $request->transaction_id;
            $refund->amount = $request->amount;
            if($refund->save()) {
                $emails = new EmailController();
                $emails->declinePrivateAnswer(base64_decode($eid) , base64_decode($qid));
                flash('Refund Request Successfully Submitted')->success();
                return back();
            }else{
                flash('Something went wrong')->error();
                return back();
            }
        }

    }

    public function claim(){
        $payments = Refund::where('expert_id',Auth::user()->id)->paginate(8);
        return view('frontend.user.claim', compact("payments"));
    }

    public function chat_admin($id){
        $refund = Refund::where('id',base64_decode($id))->first();
        return view('frontend.user.chat', compact("refund"));
    }

}
