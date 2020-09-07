<?php

namespace App\Http\Controllers\Crm;

use App\Chat;
use App\Feedback;
use App\Http\Controllers\Controller;
use App\SubCategory;
use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller
{
    public function index()
    {
        return view('crm.home');
    }

    public function get_subcategories_by_category(Request $request)
    {
        $subcategories = SubCategory::where(['category_id'=>$request->category_id,'status'=>'Active'])->get();
        return $subcategories;
    }

    public function login()
    {
        return view('crm.layout.login');
    }

    function authenticated(Request $request){

        $this->validate($request,[
           'email' =>'required|email',
           'password' =>'required|min:6'
        ]);

        $user_data = array(
            'email' => $request->email,
            'password' =>$request->password
        );


        if(Auth::attempt($user_data)){
            if(auth()->user()->type == 'Admin' )
            {
                return redirect()->route('crm.dashboard');
            }
        }else{
            return back()->with('error', "Wrong Login Details");
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('crm.login');
    }

    public function chat(Request $request){
       $chat = new Chat();
       $chat->user_id = $request->user_id;
       $chat->question_id = $request->question_id;
       $chat->massage = $request->message;
       $chat->admin = 1;
      if($chat->save()){
          flash('Message Send Successfully')->success();
          return back();
      }else{
          flash('Something went wrong')->error();
          return back();
      }

    }

    public function show_feedback(){
        $feedback = Feedback::orderBy('created_at', 'desc')->get();
        return view("crm.setting.feedback", compact('feedback'));
    }


}
