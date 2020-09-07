<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\EmailController;
use App\Referral;
use App\ReferralPayment;
use App\ReferralTree;
use App\User;
use Illuminate\Http\Request;
use Auth;
use Validator;
use Mail;
use App\Mail\EmailManager;
use Session;
class ReferralController extends Controller
{

    public function refer_user($id){
        if(!$_POST){
            if(Auth::check()){
                return redirect()->route('/');
            }
            Session::put('referrer_token', $id);
            Session::save();
            $referral =  Referral::where('remember_token', $id)->first();
            $user = User::where('id',$referral->user_id)->first();
            return view('frontend.user.registration.index', compact('referral','user'));
        }

    }

    public function send_invitation(Request $request) {
        if(!$_POST){
            return view('frontend.user.referral.email-template');
        }else{
            $referral_user = Referral::where('email',$request->email)->first();
            if($referral_user){
                flash('Already referral link sent to this mail')->success();
                return back();
            }


            $rules = [
                'first_name'=>  'required',
                'last_name' =>  'required',
                'email'     =>  'required|unique:users|email',
            ];
            $niceNames = [
                'first_name' =>  'First Name',
                'last_name' =>  'Last Name',
                'email'     =>  'Email',
            ];
            $validator = Validator::make($request->all(),$rules);
            $validator->setAttributeNames($niceNames);
            if($validator->fails()){
                return back()->withErrors($validator)->withInput();
            }else{
                $refer =new Referral();

                $refer->user_id = Auth::user()->id;
                $refer->first_name = $request->first_name;
                $refer->last_name = $request->last_name;
                $refer->email = $request->email;
                $refer->remember_token = $token =  rndString(10);

                if($refer->save()){
                    $emails = new EmailController();
                    $name = $request->first_name.' '.$request->last_name;
                    $sendName = Auth::user()->first_name.' '.Auth::user()->last_name;
                    $emails->sendInvitation($name , $request->email,$token , $sendName , $request->emailbody);

                    flash('Invitation Sent')->success();
                    return back();
                }else{
                    return back();
                }
            }
        }
    }

    public function my_referral() {
        $tree = ReferralTree::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(10);
        return view('frontend.user.referral.index' ,compact('tree'));
    }

    public function referral_status() {
        $referral =  Referral::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(10);
        return view('frontend.user.referral.status', compact('referral'));
    }

    public function referel_payments(){
        $payments = ReferralPayment::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(10);
        return view('frontend.user.wallet.referral', compact('payments'));
    }

}
