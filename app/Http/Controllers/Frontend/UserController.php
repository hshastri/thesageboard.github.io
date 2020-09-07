<?php

namespace App\Http\Controllers\Frontend;

use App\Answer;
use App\AskQuestion;
use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Controllers\EmailController;
use App\Payments;
use App\Referral;
use App\ReferralTree;
use App\Reputation;
use App\SubCategory;
use App\Tag;
use App\User;
use App\UserDetails;
use App\Wallet;
use Illuminate\Http\Request;
use Auth;
use Validator;
use DateTime;
use Hash;
use Mail;
use App\Mail\EmailManager;
use Session;
class UserController extends Controller
{

    public function registration(Request $request) {

        if(!$_POST){
            return view('frontend.user.registration.index');
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

                $expert = new User();
                $expert->first_name = $request->first_name;
                $expert->last_name = $request->last_name;
                $expert->username = $request->username;
                $expert->email = $request->email;
                $expert->password  = Hash::make($request->password);
                $expert->remember_token  = $token = bin2hex(random_bytes(20));
                $expert->role = 'Expertise';
                if($expert->save()){
                    $user_details = new  UserDetails();
                    $user_details->user_id = $expert->id;
                    $user_details->phone = $request->phone;
                    $user_details->save();

                    if(Session::get('referrer_token')){

                        $referral =  Referral::where('remember_token', Session::get('referrer_token'))->first();
                        $referral->isRegister='1';
                        $referral->save();

                        $tree = new ReferralTree();
                        $tree->user_id = $referral->user_id;
                        $tree->ref_user_id = $expert->id;
                        $tree->save();
                    }

                    $emails = new EmailController();
                    $name = $request->first_name.' '.$request->last_name;
                    $emails->newRegisterEmail($name , $request->email,$token);

                    flash('Please verify your account now.')->success();
                    return redirect()->route('login');
                }
                else{
                    flash('Something went wrong')->error();
                    return back();
                }
            }
        }
    }
    public function bio_info(Request $request) {
        if(!$_POST){
            if(auth()->user()->complete_step==2){
                return redirect()->route('add-expertise');
            }
            $user_details = UserDetails::where('user_id', Auth::user()->id)->first();
            return view('frontend.user.registration.bio', compact('user_details'));
        }else{
            $user =  User::findOrFail(Auth::user()->id);
            $user_details = UserDetails::where('user_id', Auth::user()->id)->first();

            if ($request->hasFile('file')) {
                $user->avatar = $request->file->store('uploads/profile');
            }
            $user->complete_step=1;
            $user->save();

            $user_details->bio = $request->bio;
            $user_details->profession = $request->profession;
            $user_details->graduation = $request->graduation;
            $user_details->country = $request->country;
            $user_details->hometown = $request->hometown;
            if($user_details->save()){
                return redirect()->route('add-expertise');
            }else{

                flash('Something went wrong')->error();
                return back();
            }
        }
    }
    public function add_expertise(Request $request) {
        if(!$_POST){
            $user_details = UserDetails::where('user_id', Auth::user()->id)->first();
            $expertise = json_decode($user_details->extra_speciality, true);
            $category =  Category::orderBy('name','ASC')->get();
            return view('frontend.user.registration.expertise', compact('expertise','category'));

        }else{
            $cat        = $request->expert_category;
            $subcat     = $request->expert_subcategory;
            /*$specialty  = $request->speciality;*/

            /*dd($cat,1);*/
            /*dd($subcat,1);*/
            /*dd($specialty,1);*/
            $expert_category=[];
            $expert_subcategory=[];
            $speciality=[];
            $merge_two = array();
            $sub_topic_array= array();
            $speciality_array= array();
            $final_array= array();
            $result=[];

            if(!empty($cat) && !empty($subcat) ) {
                foreach ($cat as $catkey=>$catval){
                    array_push($expert_category , $catval);
                    foreach ($subcat as $subcatkey=>$subval){
                        if($catkey==$subcatkey){
                            $sub_topic_array[$catval]  = $subval;
                        }
                    }
                }

                $keys = array_keys($sub_topic_array);
                for($i=0; $i < count($keys); ++$i) {
                    $merge_two=[];
                    array_push($merge_two, $sub_topic_array[$keys[$i]]);
                    $final_array[$keys[$i]]= $merge_two;
                }
                array_push($result, $final_array);
                $user = User::findOrFail(Auth::user()->id);
                $user->complete_step=2;
                $user->save();

                foreach ($subcat as $subvalss){
                    foreach ($subvalss as $sss){
                        $expert_subcategory[] = $sss;
                    }
                }


                foreach ($subcat as $subcatkey=>$subval){
                    foreach ($subval as $spTag){
                       $nametag=  SubCategory::where('id',$spTag)->first();
                       $speciality[] = $nametag->name;
                    }
                }


                $user_expertise = UserDetails::where('user_id', Auth::user()->id)->first();
                $user_expertise->expert_category = json_encode($expert_category);
                $user_expertise->expert_subcategory = json_encode($expert_subcategory);
                $user_expertise->speciality = json_encode($speciality);
                $user_expertise->extra_speciality = json_encode($final_array);

                if($user_expertise->save()){
                    return redirect()->route('topic-valuation');
                }else{
                    flash('Something went wrong')->error();
                    return back();
                }
            } else {
                flash('Please select at least one row of topic, subtopic and tags')->error();
                return back();
            }
        }
    }
    public function topic_valuation(Request $request) {
        if(!$_POST){
            if(auth()->user()->complete_step==3){
                return redirect()->route('profile-edit');
            }
            $user_details = UserDetails::where('user_id', Auth::user()->id)->first();
            return view('frontend.user.registration.valuation',compact('user_details'));
        }else{
            $user =  User::findOrFail(Auth::user()->id);
            $user->complete_step=3;
            $user->save();

            $user_expertise = UserDetails::where('user_id', Auth::user()->id)->first();
            $user_expertise->expertise_rate = $request->expertise_rate;
        }
        if($user_expertise->save()){
            return view('frontend.user.registration.success');
        }else{
            flash('Something went wrong')->error();
            return back();
        }
    }

    public function fetch_topic(Request $request) {
        $category =  Category::whereNotIn('id', json_decode($request->data))->orderBy('name','ASC')->get();
        $i= rand(000,999);
        return view('frontend.user.registration.partial', compact('category','i'));

    }
    public function get_subtopic(Request $request) {
        if($request->data!=''){
            $subcategory =  SubCategory::where('category_id', $request->data)->where('status','Active')->orderBy('name', 'asc')->get();
            return view('frontend.user.registration.subpartial', compact('subcategory'));
        }
    }
    public function get_tags(Request $request) {

            $tags =  Tag::where('tags','Like','%'.$request->search.'%')->where('status','Active')->get();
            $sendtags = array();
            foreach($tags as $tag) {
                $sendtags[] = array('text' => $tag->tags, 'id' => $tag->id);
            }
        echo json_encode($sendtags);
    }
    public function users(Request $request){
        $setname=null;
        $expert = User::where('role','Expertise');
        if($request->name){
            $expert = $expert->where('first_name','Like','%'.$request->name.'%')->orWhere('last_name','Like','%'.$request->name.'%');
            $setname=$request->name;
        }
        $expert = $expert->paginate(10);
        return view('frontend.experts', compact('expert','setname'));

    }
    public function user_deshboard(){
        $aap=0;
        $reputation = Reputation::where('user_id',Auth::user()->id)->get();
        $user_details = UserDetails::where('user_id',Auth::user()->id)->first();
        $answer = Answer::where(['user_id'=>Auth::user()->id,'type'=>'1']);
        $total_answer = $answer->count();
        $accepted_answer = $answer->where('accepted','yes')->count();
        if($total_answer>0){
            $aap =floor(($accepted_answer*100)/$total_answer) ;
        }
        $art = $this->calculate_avg_time(Auth::user()->id);
        return view('frontend.user.deshboard', compact('user_details','reputation','aap','art','total_answer'));
    }
    public function user_profile($id){
        $aap=0;
        $user_details =  UserDetails::where('user_id', base64_decode($id))->first();
        if(!$user_details){
            return redirect()->route('/');
        }
        $users=  User::where('id', base64_decode($id))->first();
        $reputation = Reputation::where('user_id',base64_decode($id))->get();
        $answer = Answer::where('user_id',base64_decode($id));
        $answers = $answer->take(4)->get();

        $total_answer = $answer->count();
        $accepted_answer = $answer->where('accepted','yes')->count();
        if($total_answer>0){
            $aap =floor(($accepted_answer*100)/$total_answer) ;
        }
        $art = $this->calculate_avg_time(base64_decode($id));
        return view('frontend.user_profile', compact('users','user_details','reputation','answers','aap','art'));
    }


    public function my_profile($id){
        $aap=0;
        $users=  User::where('username', $id)->first();
        $user_details =  UserDetails::where('user_id', $users->id)->first();

        $reputation = Reputation::where('user_id',$users->id)->get();
        $answer = Answer::where('user_id',$users->id);
        $answers = $answer->take(4)->get();

        $total_answer = $answer->count();
        $accepted_answer = $answer->where('accepted','yes')->count();
        if($total_answer>0){
            $aap =floor(($accepted_answer*100)/$total_answer) ;
        }
        $art = $this->calculate_avg_time($users->id);
        return view('frontend.user_profile', compact('users','user_details','reputation','answers','aap','art'));
    }


    public function calculate_avg_time($id){
        $answer = Answer::where('user_id',$id)->get();
        $total_hours= 0;
        if(count($answer)>0){
            $newhours = 0;

            foreach ($answer as $value){
                $question =  AskQuestion::where(['id'=>$value->question_id,'question_label'=>'Premium','is_deleted'=>'0'])->first();
                if($question){
                    $date1 = new DateTime($question->created_at);
                    $date2 = new DateTime($value->created_at);

                    $diff = $date2->diff($date1);
                    $hours = $diff->h;
                    $hours = $hours + ($diff->days*24);
                    $newhours = $newhours + $hours;
                }
            }

            $total_hours = $newhours/count($answer);
        }
        /*dd($total_hours,1);*/
        return convertHour($total_hours);
    }



    public function profile_edit(Request $request){
        if(!$_POST){
            $user_details = UserDetails::where('user_id', Auth::user()->id)->first();
            $dbcategory = Category::where('status','Active')->get();
            $dbsubcategory = SubCategory::where('status','Active')->get();
            $dbtag = Tag::where('status','Active')->select('id','tags')->get();
            return view('frontend.user.edit_profile', compact('user_details','dbcategory','dbtag','dbsubcategory'));
        }else{

            $user =  User::findOrFail(Auth::user()->id);
            $user_details = UserDetails::where('user_id', (Auth::user()->id))->first();

            if($request->account==1){
                $user->first_name = $request->first_name;
                $user->last_name = $request->last_name;
                if ($request->hasFile('file')) {
                    $user->avatar = $request->file->store('uploads/profile');
                }
                $user->save();
                $user_details->bio = $request->bio;
                $user_details->profession = $request->profession;
            }

            if($request->basic==1){
                $user_details->graduation = $request->graduation;
                $user_details->college = $request->college;

                $user_details->country = $request->country;
                $user_details->hometown = $request->hometown;
                $user_details->contactmail = $request->contactmail;
                $user_details->phone = $request->phone;

                $user_details->street = $request->street;
                $user_details->zipcode = $request->zipcode;
                $user_details->city = $request->city;
            }

            if($request->zone==1){
                $user_details->fblink = $request->fblink;
                $user_details->twitterlink = $request->twitterlink;
                $user_details->linkedin = $request->linkedin;
                $user_details->website = $request->website;
                $user_details->googleplus = $request->googleplus;
            }
            if($request->expertise==1){

                $user =  User::findOrFail(Auth::user()->id);
                $user->complete_step=3;
                $user->save();

                $user_details->expertise_rate = $request->expertise_rate;
                $user_details->expert_category = json_encode($request->expert_category);
                $user_details->expert_subcategory = json_encode($request->expert_subcategory);
                $user_details->speciality = json_encode($request->speciality);
            }

            if($user_details->save()){
                flash("Profile Update Successfully")->success();
                return redirect()->route('profile-edit');
            }else{
                flash('Something went wrong')->error();
                return back();
            }


        }
    }

    public function expertise(Request $request){
        if(!$_POST){
            $user_details = UserDetails::where('user_id', Auth::user()->id)->first();
            $dbcategory = Category::where('status','Active')->get();
            $dbsubcategory = SubCategory::where('status','Active')->get();
            $dbtag = Tag::where('status','Active')->select('id','tags')->get();
            return view('frontend.user.expertise', compact('user_details','dbcategory','dbtag','dbsubcategory'));
        }else{
            $user_details = UserDetails::where('user_id', Auth::user()->id)->first();

            if($request->expertise==1){

                $user =  User::findOrFail(Auth::user()->id);
                $user->complete_step=3;
                $user->save();

                $user_details->expertise_rate = $request->expertise_rate;
                $user_details->expert_category = json_encode($request->expert_category);
                $user_details->expert_subcategory = json_encode($request->expert_subcategory);
                $user_details->speciality = json_encode($request->speciality);
            }

            if($user_details->save()){
                flash("Profile Update Successfully")->success();
                return redirect()->route('expertise');
            }else{
                flash('Something went wrong')->error();
                return back();
            }


        }
    }

    public function expert_zone(Request $request){
        $setdata=1;
        if($request->question==2){
            /*$ask = AskQuestion::select('experties_ids','id')->get();
            $expert_arry = array();
            foreach($ask as $question){
                foreach (json_decode($question->experties_ids) as $value){
                    if($value==Auth::user()->id){
                        array_push($expert_arry, $question->id);
                    }
                }
            }
            $questions = AskQuestion::whereIn('id', $expert_arry);*/
            $questions = AskQuestion::whereRaw('JSON_SEARCH(experties_ids, "one","'.Auth::user()->id.'") IS NOT NULL');
            $setdata=2;
        }else{
            $questions = AskQuestion::where('user_id', Auth::user()->id);
        }
        $questions = $questions->orderBy('id','DESC')->where('question_label','Premium')->paginate(8);
        return view('frontend.user.expert_zone', compact('questions','setdata'));
    }

    public function user_activity(){

        $questions = AskQuestion::where(['user_id'=> Auth::user()->id,'question_label'=>'General','is_deleted'=>'0'])->orderBy('id','DESC')->paginate(8);

        $art= 0;
        $aap= 0;
        $answer = Answer::orderBy('id','DESC')->where(['user_id' => Auth::user()->id,'type'=>'1']);

        $total_answer = $answer->count();
        $accepted_answer = $answer->where('accepted','yes')->count();
        if($total_answer>0){
            $aap =floor(($accepted_answer*100)/$total_answer) ;
        }
        $art = $this->calculate_avg_time(Auth::user()->id);

        $total_question = AskQuestion::where(['user_id'=> Auth::user()->id,'question_label'=>'General','is_deleted'=>'0'])->count();

        return view('frontend.user.user_activity', compact('questions','total_answer','total_question','aap','art'));
    }

    public function score_allocation(){
        $reputation = Reputation::where('user_id',Auth::user()->id)->get();

        $art= 0;
        $aap= 0;
        $answer = Answer::orderBy('id','DESC')->where(['user_id' => Auth::user()->id,'type'=>'1']);

        $total_answer = $answer->count();
        $accepted_answer = $answer->where('accepted','yes')->count();
        if($total_answer>0){
            $aap =floor(($accepted_answer*100)/$total_answer) ;
        }
        $art = $this->calculate_avg_time(Auth::user()->id);

        $total_question = AskQuestion::where(['user_id'=> Auth::user()->id,'question_label'=>'General','is_deleted'=>'0'])->count();

        return view('frontend.user.score-allocation', compact('reputation','total_answer','total_question','aap','art'));
    }

    public function user_answer(){
        $art= 0;
        $aap= 0;
        $answer = Answer::orderBy('id','DESC')->where(['user_id'=> Auth::user()->id,'unicode'=>null]);

        $answers = $answer->paginate(8);
        $total_answer = $answer->count();
        $accepted_answer = $answer->where('accepted','yes')->count();
        if($total_answer>0){
            $aap =floor(($accepted_answer*100)/$total_answer) ;
        }
        $art = $this->calculate_avg_time(Auth::user()->id);

        $total_question = AskQuestion::where(['user_id'=> Auth::user()->id,'question_label'=>'General','is_deleted'=>'0'])->count();
        return view('frontend.user.answer_activity',compact('answers', 'total_answer','aap','art','total_question'));
    }

    public function checkUsername(Request $request){
        $duplicateUsername = User::where('username', '=',  $request->username)
                            ->where('id', '<>', Auth::user()->id)
                            ->count();
        if ( $duplicateUsername > 0 ) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }
}
