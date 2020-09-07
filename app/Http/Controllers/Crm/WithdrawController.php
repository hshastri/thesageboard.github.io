<?php

namespace App\Http\Controllers\Crm;

use App\AskQuestion;
use App\Http\Controllers\Controller;
use App\Refund;
use App\Http\Controllers\PaypalController;
use App\Wallet;
use Illuminate\Http\Request;

class WithdrawController extends Controller
{

    public function index() {
        $with = Wallet::orderBy('created_at', 'desc')->get();
        return view("crm.withdrawal.index", compact('with'));
    }

    public function refund_request() {
        $refund = Refund::orderBy('created_at', 'desc')->get();
        return view("crm.refund.index", compact('refund'));
    }

    public function refund_details($qid,$uid,$eid,$rid) {
        $question = AskQuestion::where('id',$qid)->first();
        $refund = Refund::where('id', $rid)->first();
        return view("crm.refund.single", compact('question','refund'));
    }

    public function release_refund(Request $request , $rid) {
        if(!$_POST){
            $payment = new PaypalController();
            $barer_toekn = $payment->getBarerToken();
            $data = json_decode($barer_toekn);
            if($data) {
                $token = $data->access_token;
            }
            $refund = Refund::where('id', $rid)->first();
            return view("crm.refund.refund_release", compact('refund','token'));
        }else{
            $payments = new PaypalController();
            $success = $payments->makeRefund($request->transaction_id,$request->barer_toekn, $request->amount);
            $data = json_decode($success);
            if(@$data->state=="completed"){
                $refund  = Refund::where('id', $rid)->first();
                $refund->status = "Completed";
                $refund->save();
                flash('Refund Successfully')->success();
                return back();
            }else{
                if(@$data->message){
                    flash(@$data->message)->error();
                }
                return back();
            }
        }
    }

    public function suspend_refund($rid) {
        if(!$_POST){
            $refund = Refund::where('id', $rid)->first();
            return view("crm.refund.suspend", compact('refund'));
        }else{
            $refund  = Refund::where('id', $rid)->first();
            $refund->status = "Suspended";
            $refund->save();
            flash('Refund Suspended')->success();
            return back();
        }

    }

}
