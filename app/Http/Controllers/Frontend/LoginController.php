<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\UserDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Laravel\Socialite\Facades\Socialite;
use App\User;
use Session;
class LoginController extends Controller
{
    public function redirectToProvider($provider , $point=null)
    {
        if($point){
            Session::put('redirect_question_id', $point);
        }else{
            if(Session::has('redirect_question_id')){
                Session::forget('redirect_question_id');
            }
        }

        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback(Request $request, $provider)
    {
        try {
            $user = Socialite::driver($provider)->stateless()->user();
        } catch (\Exception $e) {
            flash("Something Went wrong. Please try again.")->error();
            return redirect()->route('login');
        }
        $existingUser = User::where('provider_id', $user->id)->orWhere('email', $user->email)->first();
        if($existingUser){
            auth()->login($existingUser, true);

            $key = auth()->getRecallerName();
            Cookie::queue($key, Cookie::get($key), 10080);
        } else {
            $fullpath ='';
            $newUser                  = new User;

            $name = explode(" ", $user->name);
            $name2 ='';

            foreach ($name as $key=>$value){
                if($key!=0){
                    $name2.=' '.$value;
                }
            }

            $newUser->first_name      = $name[0];
            $newUser->last_name       = ltrim($name2);
            $newUser->username        = $this->makeUniqueName($name[0]);
            $newUser->email           = $user->email;
            $newUser->status          = 'Active';
            $newUser->role            = 'Expertise';
            $newUser->isLogin         ='1';
            $newUser->provider_id     = $user->id;

            if ($user->getAvatar()) {
                $extension  ='jpg';
                $filename   = 'uploads/profile/'.time().'-'.$user->id.'.'.$extension;
                $fullpath   = 'public/'.$filename;
                $file       = file_get_contents($user->avatar_original);
                file_put_contents($fullpath, $file);
                $newUser->avatar = $filename;
            }
            $newUser->save();
            $user_details           = new  UserDetails();
            $user_details->user_id  = $newUser->id;
            $user_details->save();
            auth()->login($newUser, true);

            $key = auth()->getRecallerName();
            Cookie::queue($key, Cookie::get($key), 10080);

            return view('frontend.login.confirm_screen' , compact('newUser','provider','fullpath'));
            /*
            flash('Registration Complete. Thank you! Please goto <a href="'.route('user-deshboard').'">My Profile</a> and fill out the remainder of your profile')->success();
            */
        }
        if(session('link') != null){
            return redirect(session('link'));
        }
        else{
            /*if(auth()->user()->isLogin==0){
                $user_login             = User::where('provider_id', $user->id)->orWhere('email', $user->email)->first();
                $user_login->isLogin    ='1';
                $user_login->save();
                return redirect()->route('expert-bio');
            }*/

            if(Session::has('redirect_question_id')){
                $qsn_id = Session::get('redirect_question_id');
                return redirect()->route('question-details', $qsn_id);
            }
            return redirect()->route('/');
        }
    }

    public function social_login_confirmation(Request $request) {
        $user  = User::where('id', Auth::id())->first();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        if($request->username!=$user->username){
            $user->username = $request->username;
        }

        $user->save();
        if($request->home){
            return redirect()->route('/');
        }
        if($request->profile){
            return redirect()->route('expert-bio');
        }

        if($request->answer){
            $qsn_id = Session::get('redirect_question_id');
            return redirect()->route('question-details', $qsn_id);
        }
        return view('frontend.login.confirm_screen');
    }

    public function makeUniqueName($name){
        if (User::where('username', '=', $name)->count() > 0) {
            $make_name = $name.rand(10,100);
            return $this->makeUniqueName($make_name);
        }else{
            return $name;
        }
    }
}
