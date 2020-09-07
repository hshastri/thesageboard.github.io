<?php

namespace App\Http\Controllers\Frontend;;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PaypalController;
use App\UserDetails;
use App\Wallet;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Str;

class WithdrawController extends Controller
{
    public function disbursement(){
        $payments = Wallet::where('user_id',Auth::user()->id)->orderBy('created_at', 'desc')->paginate(8);
        $balance = UserDetails::where("user_id", Auth::user()->id)->value('balance');
        return view('frontend.user.wallet.disbursement',compact('payments','balance'));
    }

    public function get_paid(Request $request){
        if(!$_POST){
            $payment = new PaypalController();
            $barer_toekn = $payment->getBarerToken();
            $data = json_decode($barer_toekn);
            if($data) {
                $token = $data->access_token;
            }
            $user = UserDetails::where("user_id", Auth::user()->id)->first();
            return view('frontend.user.wallet.get-paid', compact('user','token'));
        }else{
            $payment_id = Str::random(10);
            $payment = new PaypalController();
            $response = $payment->payoutRequest($request->token,$request->withdraw_amount,$request->account,$payment_id);
            $data = json_decode($response);
            if(@$data->batch_header->batch_status) {
                $wallet = new Wallet();
                $wallet->user_id = Auth::user()->id;
                $wallet->amount = $request->withdraw_amount;
                $wallet->message = $request->message;
                $wallet->title = $request->title;
                $wallet->account = $request->account;
                $wallet->transaction_id = $payment_id;
                $wallet->status = "Completed";
                $wallet->save();

                $users = UserDetails::where('user_id', Auth::user()->id)->first();
                if($users->balance!= null && $users->balance >= $request->withdraw_amount){
                    $users->balance =  $users->balance - $request->withdraw_amount;
                    $users->save();
                }else{
                    flash("Amount Not Exist")->success();
                    return redirect()->route('wallet');
                }

                flash("Successfully Send To Your Withdraw Request")->success();
            }else{
                flash("Cancel Withdraw Request")->success();
            }

            return redirect()->route('wallet');
        }
    }
}
