<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Payments;
use App\User;
use App\UserDetails;
use Illuminate\Http\Request;
use Auth;
class WalletController extends Controller
{
    public function user_wallet(){
        $payments = Payments::where('expert_id',Auth::user()->id)->orWhere('cost_id',Auth::user()->id);

        $pending_amount = Payments::where(['expert_id'=>Auth::user()->id,'status'=>'Pending'])->selectRaw('sum(amount) as amount')->first();
        if($pending_amount->amount!= null){
            $pending_amount = $pending_amount->amount;
        }else{
            $pending_amount = 0;
        }
        $balance = UserDetails::where("user_id", Auth::user()->id)->value('balance');

        $cost = Payments::where(['status'=>'Cost','cost_id'=>Auth::user()->id])->selectRaw('sum(amount) as amount')->first();
        if($cost->amount!= null){
            $cost = $cost->amount;
        }else{
            $cost = 0;
        }
        $payments = $payments->orderBy('created_at', 'desc')->paginate(8);
        return view('frontend.user.wallet.wallet', compact("payments",'pending_amount','balance','cost'));
    }
    public function in_progress(){
        $payments = Payments::where(['expert_id'=>Auth::user()->id,'status'=>'Pending'])->orderBy('created_at', 'desc')->paginate(8);
        return view('frontend.user.wallet.in-progress', compact('payments'));
    }
    public function user_earnings(){
        $payments = Payments::where(['expert_id'=>Auth::user()->id,'status'=>'Earnings'])->orderBy('created_at', 'desc')->paginate(8);
        $balance = UserDetails::where("user_id", Auth::user()->id)->value('balance');
        return view('frontend.user.wallet.earnings',compact('payments','balance'));
    }
    public function user_balance(){

        $payments = Payments::where(['expert_id'=>Auth::user()->id,'status'=>'Earnings'])->orderBy('created_at', 'desc')->paginate(8);
        $balance = UserDetails::where("user_id", Auth::user()->id)->value('balance');
        return view('frontend.user.wallet.balance',compact('payments','balance'));
    }
    public function user_costs(){
        $payments = Payments::where(['cost_id'=>Auth::user()->id,'status'=>'Earnings'])->orderBy('created_at', 'desc')->paginate(8);
        return view('frontend.user.wallet.costs', compact('payments'));
    }
    public function payment_setting(Request $request){
        if(!$_POST){
            return view('frontend.user.wallet.settings');
        }else{
            $used = UserDetails::where('user_id', Auth::user()->id)->first();
            $used->paypalEmail = $request->paypalEmail;
            $used->save();
            flash('Successfully Save Your Paypal Info')->success();
            return redirect('wallet');
        }
    }
    public function setup_payment(Request $request){
        $user = User::where('id', Auth::user()->id)->first();
        if (Hash::check($request->password, $user->password)) {
            return view('frontend.user.wallet.setup-payment');
        }else{
            flash('Invalid Password')->error();
            return back();
        }
    }
}
