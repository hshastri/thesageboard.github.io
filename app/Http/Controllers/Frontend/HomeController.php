<?php

namespace App\Http\Controllers\Frontend;

use App\Answer;
use App\AskQuestion;
use App\BasicSetting;
use App\Category;
use App\Chat;
use App\ChatRoom;
use App\Feedback;
use App\Http\Controllers\Controller;
use App\Http\Controllers\EmailController;
use App\Reputation;
use App\SubCategory;
use App\Tag;
use App\User;
use App\UserDetails;
use Illuminate\Http\Request;
use Hash;
use Auth;
use Session;
use Validator;
use Illuminate\Support\Facades\Cookie;
use DB;
class HomeController extends Controller
{

    public function index(Request $request)
    {

        if(Auth::check() && Auth::user()->type=='Admin'){
            Auth::logout();
            flash('Destroy CRM Session')->error();
        }
        $category = BasicSetting::where('key', 'categories_id')->first();
        if($category){
            $string = str_replace('\n', '', $category->value);
            $string = rtrim($string, ',');
            $string = "[" . trim($string) . "]";
            $category = json_decode($string, true);
        }

        $user = UserDetails::orderBy('general_reputation_score', 'DESC')->limit(20)->get();

        return view('frontend.home', compact('category','user'));
    }
    public function test_login() {
        return view('frontend.test-login');
    }
    public function load_home_question_section(){
        $question = AskQuestion::where(['question_label'=>'General','is_deleted'=>'0'])->orderBy('id', 'DESC')->take(10)->get();
        return view('frontend.partial.home_question_section', compact('question'));

    }
    public function login()
    {
        if(Auth::check()){
            return back();
        }
        $path = basename(previous());

        if($path=="expert-register" || $path=="register" || $path=="login"){
        }else{
            Session::put('redirect', previous());
        }
        return view('frontend.login');
    }

    public function register(Request $request){
        if(!$_POST){
            return view('frontend.registration');
        }else{
            $rules = [
                'first_name'=>  'required',
                'last_name' =>  'required',
                'username'  =>  'required|unique:users',
                'email'     =>  'required|unique:users|email',
                'password'          => 'min:6|required_with:confirm_password|same:confirm_password',
                'confirm_password'  => 'min:6|required',
                'checkbox'  => 'required',
            ];
            $niceNames = [
                'first_name' =>  'First Name',
                'last_name' =>  'Last Name',
                'username'  =>  'Username',
                'email'     =>  'Email',
                'password'  =>  'Password',
                'confirm_password'  =>  'Confirm Password',
                'checkbox'  =>  'Term and Condition',
            ];
            $validator = Validator::make($request->all(),$rules);
            $validator->setAttributeNames($niceNames);
            if($validator->fails()){
                return back()->withErrors($validator)->withInput();
            }else{
                $user = new User();
                $user->first_name = $request->first_name;
                $user->last_name = $request->last_name;
                $user->username = $request->username;
                $user->email = $request->email;
                $user->password  = Hash::make($request->password);
                $user->remember_token  = $token = bin2hex(random_bytes(20));
                $user->role = 'General';
                if($user->save()){
                    $user_details = new  UserDetails();
                    $user_details->user_id = $user->id;
                    $user_details->phone = $request->phone;
                    $user_details->save();

                    $emails = new EmailController();
                    $name = $request->first_name.' '.$request->last_name;
                    $emails->newRegisterEmail($name , $request->email,$token);

                    flash('Registration Confirmed, Please Confirm your Email')->success();
                    return redirect()->route('login');
                }
                else{
                    flash('Something went wrong')->error();
                    return back();
                }
            }
        }
    }

    function authenticated(Request $request){

        $this->validate($request,[
            'email' =>'required',
            'password' =>'required|min:6'
        ]);
        $remeber = false;
        $users = User::where('email', $request->email)->orwhere('username', $request->email)->first();
        if($users){
            if($users->status=='Disable'){
                flash('Please Verify Your Email')->error();
                return back();
            }

            if( Hash::check($request->password, $users->password)){
                if($request->checkbox){
                    $remeber = true;
                }
                auth()->login($users , $remeber);

                if($remeber==true){

                    $key = auth()->getRecallerName();
                    Cookie::queue($key, Cookie::get($key), 10080);
                }

                if(auth()->user()->type == 'User' )
                {
                    if(auth()->user()->role == 'Expertise' && auth()->user()->isLogin==0){

                        $user_login =  User::where('email', $request->email)->orwhere('username', $request->email)->first();
                        $user_login->isLogin='1';
                        $user_login->save();

                        return redirect()->route('expert-bio');
                    }

                    if ($redirect = Session::get('redirect')) {
                        Session::forget('redirect');
                        return redirect()->to($redirect);
                    }else{
                        return redirect()->route('/');
                    }
                }else{
                    Auth::logout();
                    flash('Email or Password incorrect')->error();
                    return back()->with('error', "Email or Password incorrect");
                }
            }else{
                flash('Email or Password incorrect')->error();
                return back();
            }
        }else{
            flash('Email or Password incorrect')->error();
            return back();
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        flash('Logged Out')->success();
        return redirect()->route('/');
    }


    public function user_questions(){
       $ask_question =  AskQuestion::where('user_id', Auth::user()->id)->orderBy('updated_at', 'desc')->get();
       return view('frontend.user.user_question',compact('ask_question'));
    }

    public function widget_question_load(){
        $question = AskQuestion::where(['question_label'=>'General','is_deleted'=>'0'])->whereBetween('created_at', array(date('Y-m-d H:i:s',strtotime('-168 hour')), date('Y-m-d H:i:s')))->orderBy('totalview', 'DESC')->limit(4)->get();
        return view('frontend.partial.widget_question', compact('question'));
    }

    public function widget_expert_load(){
        $user = UserDetails::orderBy('general_reputation_score', 'DESC')->limit(4)->get();
        return view('frontend.partial.widget_expert', compact('user'));
    }

    public function prepoulated_tags(Request $request){
        if($request->data!=''){
            $tags =  Tag::where('tags','Like','%'.$request->data.'%')->where('status','Active')->get();
            return view('frontend.partial.all_tags', compact('tags'));
        }
    }

    public function populated_subcategory(Request $request){
        if($request->data!=''){
            $category =  Category::whereIn('id', $request->data)->where('status','Active')->get();
            return view('frontend.partial.subcategory', compact('category'));
        }
    }
    public function chat(Request $request){
        $chat = new Chat();
        $chat->user_id = $request->user_id;
        $chat->question_id = $request->question_id;
        $chat->massage = $request->message;
        $chat->admin = 0;
        if($chat->save()){
            flash('Message Send Successfully')->success();
            return back();
        }else{
            flash('Something went wrong')->error();
            return back();
        }
    }

    public function verify_email($token){
        $user = User::where('remember_token', $token)->first();
        if($user){
            $user->status ="Active";
            $user->save();
            flash('Email Confirmed')->success();
            return redirect()->route('login');
        }else{
            flash('Something went wrong')->error();
            return redirect()->route('/');
        }
    }

    public function forget_password(Request $request){
        if(!$_POST){
            if(Auth::check()){
                Auth::logout();
            }
            return view('frontend.login.forgot_password');
        }else{
            $user =  User::where('email', $request->email)->first();
            if($user){
                $user->remember_token = $token = rand(10000,99999);
                $user->save();

                $name = $user->first_name.' '.$user->last_name;
                $user_mail = $user->email;
                $emails = new EmailController();
                $emails->fogetPassword($name,$user_mail,$token);
                flash('A one-time code has been sent to your e-mail. Please verify to reset your password')->success();
                return view('frontend.login.verify_otp', compact('user_mail'));
            }else{
                flash('Please Register Your Email First')->error();
                return redirect()->route('login');
            }
        }
    }


    public function verify_otp(Request $request){
        if(!$_POST){
            return view('frontend.login.verify_otp');
        }else{
            $user_mail = $request->email;
            $user =  User::where(['email'=>$request->email,'remember_token'=> $request->token])->first();
            if($user){
                return view('frontend.login.change_password', compact('user'));
            }else{
                flash('OTP not match')->error();
                return view('frontend.login.verify_otp', compact('user_mail'));
            }

        }
    }

    public function change_password(Request $request){
        if(!$_POST){
            return view('frontend.login.change_password');
        }else{
            $user =  User::where(['email'=>$request->email,'remember_token'=> $request->token])->first();
            if($user){
                $user->password  = Hash::make($request->password);
                if($user->save()){
                    flash('Password Change Successfully')->error();
                    return redirect()->route('login');
                }
            }else{
                flash('Something went wrong')->error();
                return back();
            }
        }

    }

    public function feedback(Request $request){
        $feedback =new Feedback;
        $feedback->user_id= Auth::user()->id;
        $feedback->score= $request->score;
        $feedback->comment= $request->comment;
        if($feedback->save()){
            flash('Thanks for your valuable feedback')->success();
            return back();
        }else{
            flash('Something went wrong')->error();
            return back();
        }
    }
    public function listings() {
        $category  = Category::orderBy('name', 'ASC')->get();
        return view('frontend.listings', compact('category'));
    }

    public function terms_conditions() {
        return view('frontend.privacy');
    }
    public function terms_service() {
        return view('frontend.terms-services');
    }
    public function testmail(){
        $emails = new EmailController();
        $emails->acceptPrivateAnswer(28 , 50);
       /* $emails->newRegisterEmail('shakil','shakil.techvill@gmail.com','123456789');*/
    }
    public function mail_template() {
        return view('Crm.emails.accept-answer');
    }
}
