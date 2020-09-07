<?php

namespace App\Http\Controllers\Frontend;

use App\Answer;
use App\AskQuestion;
use App\BasicSetting;
use App\Category;
use App\ChatRoom;
use App\Comment;
use App\Http\Controllers\Controller;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\PaypalController;
use App\Notify;
use App\Question;
use App\QuestionComment;
use App\SubCategory;
use App\Tag;
use App\User;
use App\UserDetails;
use App\Voting;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Str;
use Session;
use App\PaymentDetails;
use Validator;
use File;
use ZipArchive;
use DateTime;
use DateTimeZone;
use Image;
use DB;
class AskQuestionController extends Controller
{
    public function index(Request $request)
    {
        if(!$_POST){
            $recent = AskQuestion::orderBy('id', 'DESC')->where(['question_label'=>'General','is_deleted'=>'0'])->limit(5)->get();
            /*$tag =  Tag::where('status','Active')->select('id','tags')->get();*/
            $edit_form =0;
            $category = Category::where('status','Active')->orderBy('name', 'asc')->get();


            return view('frontend.ask_question',compact('recent','edit_form','category'));
        }else{

            if(!$request->set_category_id){
                flash('Select At least One Category')->error();
                return back();
            }

            $rules = [
                'question_title' =>  'required',
                'description'    =>  'required',
                'tags'           =>  'required|array|min:1',
            ];
            $niceNames = [
                'question_title' =>  'Question Title',
                'description'    =>  'Description',
                'tags.0'           =>  'Tags',
            ];
            $validator = Validator::make($request->all(),$rules);
            $validator->setAttributeNames($niceNames);
            if($validator->fails()){
                return back()->withErrors($validator)->withInput();
            }else{
                $askQuestion = new AskQuestion();
                $askQuestion->user_id = Auth::user()->id;
                $askQuestion->question_title = $request->question_title;
                $askQuestion->slug = $this->generateArticleslug($request->question_title);
                $askQuestion->description = $request->description;
                $askQuestion->tags =  implode('|',$request->tags);
                $askQuestion->category_id = $request->set_category_id;
                $askQuestion->subcategory_id = $request->set_sub_category_id;
                $files = array();
                if($request->hasFile('file')){
                    foreach ($request->file as $key => $file) {
                        $extension = $file->getClientOriginalExtension();
                        if($extension=="jpg" || $extension=="png" || $extension=="jpeg" || $extension=="gif" || $extension=="docx" || $extension=="pdf"){

                            $namewithextension = $file->getClientOriginalName();
                            $name = explode('.', $namewithextension)[0];
                            $custom_file_name = $name.'_'.time().$extension;
                            $path = $file->storeAs('uploads', $custom_file_name);

                            array_push($files, $path);
                        }else {
                            flash("File Type Not Supported")->error();
                            return back();
                        }
                    }
                    $askQuestion->file = json_encode($files);
                }

               if($askQuestion->save()){
                   $this->isertForTopic($request->set_category_id,$askQuestion->id,$request->set_sub_category_id);
                    if($request->sage){
                        $id = base64_encode($askQuestion->id);
                        $first_level_experts = $keepeloquentobj = UserDetails::whereNotIn('user_id', array(Auth::user()->id))->whereRaw('JSON_SEARCH(expert_category, "one","'.$request->set_category_id.'") IS NOT NULL');
                        $experts_by_topic       = $first_level_experts->orderBy('general_reputation_score','DESC')->get();
                        $final_experts          = $keepeloquentobj->whereRaw('JSON_SEARCH(expert_subcategory, "one","'.$request->set_sub_category_id.'") IS NOT NULL');
                        $experts_by_subtopic    = $final_experts->orderBy('general_reputation_score','DESC')->orderBy('expert_reputation_score','DESC')->get();

                       /*$user_details =  UserDetails::whereRaw('JSON_SEARCH(expert_category, "one","'.$request->set_category_id.'") IS NOT NULL')->whereRaw('JSON_SEARCH(expert_subcategory, "one","'.$request->set_sub_category_id.'") IS NOT NULL');
                        $experts = $user_details->orderBy('general_reputation_score','DESC')->orderBy('expert_reputation_score','DESC')->get();--}}
                       /* dd($experts,1);*/

                        return view('frontend.question.expert_list', compact( 'experts_by_subtopic','experts_by_topic', 'id'));
                    }else{
                        $data['question_id'] = $askQuestion->id;
                        $data['question_slag'] = $askQuestion->slug;
                        return view('frontend.question.success', $data);
                    }
                }else{
                   return back();;
                }
            }
        }
    }
    public function  get_single_subcategory(Request $request){
        $subcategory =  SubCategory::where(['category_id'=> $request->id , 'status'=>'Active'])->orderBy('name', 'asc')->get();
        return view('frontend.partial.single_subcategory', compact('subcategory'));
    }

    public function realiable_yes(Request $request, $id){
        if(!$_POST){
            $category = Category::where('status','Active')->orderBy('created_at', 'desc')->get();
            return view('frontend.question.reliable_yes',compact('category','id'));
        }else{
            $questions =  AskQuestion::findOrFail(base64_decode($id));
            $questions->category_id = $request->category_id;
            if($questions->save()){
                $subcategory =  SubCategory::where(['category_id'=> $request->category_id , 'status'=>'Active'])->get();
                return view('frontend.question.sub', compact('subcategory', 'id'));
            }else{
                return back();
            }
        }
    }

    public function question_type(Request $request, $id){
        if(!$_POST){
            $subcategory =  SubCategory::where(['category_id'=> $request->category_id , 'status'=>'Active'])->get();
            return view('frontend.question.sub', compact('subcategory', 'id'));
        }else{
            if($request->subcategory_id){
                $questionsub =  AskQuestion::findOrFail(base64_decode($id));
                $questionsub->subcategory_id = $request->subcategory_id;
                $questionsub->type = "Public";
                if($questionsub->save()){
                    $expert = User::where(['role'=>'Expertise'])->where('id','!=', Auth::user()->id)->get();
                    return view('frontend.question.expert_list', compact( 'expert','id'));
                }else{
                    return back();
                }
                /*if($questionsub->save()){
                    return view('frontend.question.type', compact( 'id'));
                }else{
                    return back();
                }*/
            }else{
                $questiontype =  AskQuestion::findOrFail(base64_decode($id));
                $questiontype->type = "Public";
                if($questiontype->save()){
                    $expert = User::where(['role'=>'Expertise'])->where('id','!=', Auth::user()->id)->get();
                    return view('frontend.question.expert_list', compact( 'expert','id'));
                }else{
                    return back();
                }
            }
        }
    }

    public function chosen_expert(Request $request, $id){
        if(!$_POST){
            /*  $expert = User::where(['role'=>'Expertise'])->where('id','!=', Auth::user()->id)->get();*/
            $find                   = AskQuestion::where('id',base64_decode($id))->first();
            $first_level_experts = $keepeloquentobj = UserDetails::whereNotIn('user_id', array(Auth::user()->id))->whereRaw('JSON_SEARCH(expert_category, "one","'.$find->category_id.'") IS NOT NULL');
            $experts_by_topic       = $first_level_experts->orderBy('general_reputation_score','DESC')->get();
            $final_experts          = $keepeloquentobj->whereRaw('JSON_SEARCH(expert_subcategory, "one","'.$find->subcategory_id.'") IS NOT NULL');
            $experts_by_subtopic    = $final_experts->orderBy('general_reputation_score','DESC')->orderBy('expert_reputation_score','DESC')->get();

            return view('frontend.question.expert_list', compact( 'experts_by_subtopic','experts_by_topic', 'id'));
        }else{
            $total=0;
            $orginalAmount=0;
            foreach($request->experties_ids as $key => $value){
                $user_rate =  UserDetails::where('user_id', $value)->first();
                $subtotal = $user_rate->expertise_rate*0.03;
                $commission = $subtotal +$user_rate->expertise_rate + .03;
                $total += $commission;
                $orginalAmount += $user_rate->expertise_rate;
            }
            $questionexpert =  AskQuestion::findOrFail(base64_decode($id));
            $questionexpert->experties_ids = $request->experties_ids;
            $questionexpert->amount = $amount = $total;
            $questionexpert->payment_id = $payment_id = Str::random(20);
            if($questionexpert->save()){

                Session::put('amount', $amount);
                Session::put('orginalAmount', $orginalAmount);
                Session::put('payment_id', $payment_id);
                Session::put('experts_ids', $request->experties_ids);
                Session::save();

                $payment_detail =new PaymentDetails();
                $payment_detail->payment_uid = $payment_id;
                $payment_detail->user_id = Auth::user()->id;
                $payment_detail->question_id = base64_decode($id);

                if($payment_detail->save()){
                    $cliend_id = BasicSetting::where('key','paypal_client_id')->first();
                    $client = $cliend_id->value;
                    return view('frontend.question.paynow', compact('client'));
                }
            }else{
                return back();
            }
        }
    }


    public function answer(Request $request,$id){
        $rules = [
            'answer' =>  'required',
        ];
        $niceNames = [
            'answer' =>  'Answer',
        ];
        $validator = Validator::make($request->all(),$rules);
        $validator->setAttributeNames($niceNames);
        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }else{

            $answer = new Answer();
            $answer->question_id= base64_decode($id);
            $answer->user_id = Auth::user()->id;
            $answer->answer = $request->answer;
            $answer->type = '1';
            if($answer->save()){
                $ask_answer = AskQuestion::where('id', base64_decode($id))->first();
                $ask_answer->totalanswer = $ask_answer->totalanswer+1;
                $ask_answer->last_answer_at = date('Y-m-d H:i:s');
                $ask_answer->save();

                if(Auth::user()->id != $ask_answer->user_id){

                    $value = Str::limit($request->answer, 50);
                    $this->notifyComment(base64_decode($id) , $ask_answer->user_id, $value , 1);

                    $emails = new EmailController();
                    $emails->ansPublicQuestion(base64_decode($id) , $answer->id);
                }

                flash('Thank you for your Answer')->success();
                return back();
            }else{
                flash('Something went wrong')->error();
                return back();
            }
        }

    }

    public function private_answer(Request $request,$qid){


        $rules = [
            'answer' =>  'required',
        ];
        $niceNames = [
            'answer' =>  'Answer',
        ];
        $validator = Validator::make($request->all(),$rules);
        $validator->setAttributeNames($niceNames);
        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }else{
            $commoncode=0;
            $answer = new Answer();
            $answer->question_id= base64_decode($qid);
            $answer->user_id = Auth::user()->id;
            $answer->answer = $request->answer;
            $answer->type = '2';
            $chats =  ChatRoom::where(['question_id'=>base64_decode($qid) , 'user_one_id'=>base64_decode($request->user_one) ,'user_two_id'=>base64_decode($request->user_two)])->first();
            if($chats){
               $commoncode =  $chats->unicode;
            }else{
                $chatsroom = new ChatRoom();
                $chatsroom->question_id = base64_decode($qid);
                $chatsroom->user_one_id = base64_decode($request->user_one);
                $chatsroom->user_two_id = base64_decode($request->user_two);
                $chatsroom->unicode = $commoncode = Str::random(15);;
                $chatsroom->save();
            }
             $answer->unicode = $commoncode;
            if($answer->save()){
               $ask_answer = AskQuestion::where('id', base64_decode($qid))->first();
                /*$ask_answer->totalanswer = $ask_answer->totalanswer+1;
               $ask_answer->save();*/
               /* flash('Thanks for answer')->success();*/
                $value = Str::limit($request->answer, 50);
                if(Auth::user()->id!= $ask_answer->user_id){

                    $this->notifyComment(base64_decode($qid) , $ask_answer->user_id, $value , 2);

                    $emails = new EmailController();
                    $emails->ansPrivateQuestion(base64_decode($qid));
                }else{
                    $this->notifyComment($ask_answer->id ,  base64_decode($request->user_two), $value , 8);
                }
                return back();
            }else{
                flash('Something went wrong')->error();
                return back();
            }
        }

    }

    public function comment(Request $request,$id){

        if(!$request->anscomment){
            return response()->json([
                'message' => 'Fail',
                'status' => '400',
            ]);
        }
        $comment = new Comment();
        $comment->answer_id= base64_decode($id);
        $comment->user_id = Auth::user()->id;
        $comment->comment = $request->anscomment;
        if($comment->save()){
            return response()->json([
                'message' => 'Success',
                'status' => '200',
                'ansID' => base64_decode($id),
                'route' => route('load-ans-comment',$id),
            ]);
        }else{
            return response()->json([
                'message' => 'Fail',
                'status' => '400',
            ]);
        }
    }

    public function questions(Request $request ){
        $setCategory=null;
        $setSubcategory=null;
        $settime=null;
        $settag=null;
        $setactivity=null;
        $setquestion_title=null;
        $cat_key = null;
        $subcat_key = null;
        $keyID = null;

        if($request->question_title==null && $request->subcat_key==null && $request->cat_key==null){
            if($request->activity!= null){
                if(1 == (int)$request->activity){
                    $questions = AskQuestion::orderBy('totalanswer','DESC');
                }elseif(2 == (int)$request->activity){
                    $questions = AskQuestion::orderBy('totalvote','DESC');
                }elseif(3 == (int)$request->activity){
                    $questions = AskQuestion::orderBy('totalview','DESC');
                }elseif(4 == (int)$request->activity){
                    $questions = AskQuestion::orderBy('totalanswer', 'ASC');
                }elseif( 5 == (int)$request->activity ) {
                    $answer = Answer::orderBy('created_at','DESC')->pluck('question_id')->toArray();
                    $ids = array_unique($answer);
                    $ids_ordered = implode(',', $ids);
                    $questions = AskQuestion::whereIn('id', $ids)
                                ->orderByRaw("FIELD(id, $ids_ordered)");
                    //$questions = AskQuestion::whereIn('id', $answer)->get();
                }else{
                    $questions = AskQuestion::orderBy('created_at','DESC');
                }
                $setactivity = (int)$request->activity;
            }
            else{
                $questions = AskQuestion::orderBy('created_at','DESC');
                $setactivity = 0;
            }

        }

        if($request->question_title!=null){
            $questions = AskQuestion::where('question_title' , 'Like','%'.$request->question_title.'%');
            $setquestion_title = $request->question_title;
        }
        if($request->subcat_key!=null){
            $questions = AskQuestion::where('subcategory_id' , base64_decode($request->keyID));
            $subcat= SubCategory::where('id',base64_decode($request->keyID))->first();
            $setquestion_title = $subcat->name;
            $subcat_key = 1;
            $keyID = $request->keyID;
        }
        if( $request->cat_key!=null){
            $questions = AskQuestion::where('category_id' , base64_decode($request->keyID));
            $categorys = Category::where('id',base64_decode($request->keyID))->first();
            $setquestion_title = $categorys->name;
            $cat_key = 1;
            $keyID = $request->keyID;
        }
        if($request->activity!= null && $request->question_title!=null || $request->subcat_key!=null ||  $request->cat_key!=null){
            if(1 == (int)$request->activity){
                $questions = $questions->orderBy('totalanswer','DESC');
            }elseif(2 == (int)$request->activity){
                $questions = $questions->orderBy('totalvote','DESC');
            }elseif(3 == (int)$request->activity){
                $questions = $questions->orderBy('totalview','DESC');
            }elseif(4 == (int)$request->activity){
                $questions = $questions->where('totalanswer', '=', 0);
            }elseif( 5 == (int)$request->activity ) {
                $answer = Answer::orderBy('created_at','DESC')->pluck('question_id')->toArray();
                $ids = array_unique($answer);
                $ids_ordered = implode(',', $ids);
                $questions = AskQuestion::whereIn('id', $ids)
                            ->orderByRaw("FIELD(id, $ids_ordered)");
                //$questions = AskQuestion::whereIn('id', $answer)->get();
            } else {
                $questions = $questions->orderBy('created_at','DESC');
            }
            $setactivity = (int)$request->activity;
        }
        if($request->time!= null){
            if($request->time==1){
                $questions = $questions->whereBetween('created_at', array(date('Y-m-d H:i:s',strtotime('-1 hour')), date('Y-m-d H:i:s')));
            }elseif($request->time==2){
                $questions = $questions->whereBetween('created_at', array(date('Y-m-d H:i:s',strtotime('-4 hour')), date('Y-m-d H:i:s')));
            }elseif ($request->time==3){
                $questions = $questions->whereBetween('created_at', array(date('Y-m-d H:i:s',strtotime('-24 hour')), date('Y-m-d H:i:s')));
            }elseif ($request->time==4){
                $questions = $questions->whereBetween('created_at', array(date('Y-m-d H:i:s',strtotime('-168 hour')), date('Y-m-d H:i:s')));
            }elseif ($request->time==5){
                $questions = $questions->whereBetween('created_at', array(date('Y-m-d H:i:s',strtotime('-720 hour')), date('Y-m-d H:i:s')));
            }
            $settime = $request->time;
        }

        /*if($request->time!= null){
            $mytime = getMyTime();
            $date1 = $mytime->format('Y-m-d H:i:s');

            if((int)$request->time==1){
                $modify = $mytime->modify('- 1 hour');
                $date2 = $modify->format('Y-m-d H:i:s');
                $questions = $questions->whereBetween('created_at',array($date2 , $date1));
            }elseif((int)$request->time==2){
                $modify = $mytime->modify('- 4 hour');
                $date2 = $modify->format('Y-m-d H:i:s');
                $questions = $questions->whereBetween('created_at',array($date2 , $date1));
            }elseif ((int)$request->time==3){
                $modify = $mytime->modify('- 24 hour');
                $date2 = $modify->format('Y-m-d H:i:s');
                $questions = $questions->whereBetween('created_at',array($date2 , $date1));
            }elseif ((int)$request->time==4){
                $modify = $mytime->modify('- 168 hour');
                $date2 = $modify->format('Y-m-d H:i:s');
                $questions = $questions->whereBetween('created_at',array($date2 , $date1));
            }elseif ((int)$request->time==5){
                $modify = $mytime->modify('- 720 hour');
                $date2 = $modify->format('Y-m-d H:i:s');
                $questions = $questions->whereBetween('created_at',array($date2 , $date1));
            }
            $settime = $request->time;
        }*/

        if($request->tag!=null){
            $str_arr_tag = explode (",", $request->tag);
            foreach ($str_arr_tag as $tag) {
                $questions = $questions->orWhere('tags','Like','%'.$tag.'%');
            }
            $settag = $request->tag;
        }
        $items = BasicSetting::where('key', 'items_per_page')->first();
        if($items){
            $items = $items->value;
        }else{
            $items = 5;
        }
        $questions_all = $questions->where(['question_label'=>'General','is_deleted'=>'0'])->paginate($items);
        return view('frontend.questions',compact('questions_all','setCategory','setSubcategory','settime','settag','setactivity','setquestion_title' , 'cat_key','subcat_key' , 'keyID'));
    }

    public function filterFromCrousal($cat){
        $setCategory        = null;
        $setSubcategory     = null;
        $settime            = null;
        $settag             = null;
        $setactivity        = null;
        $setquestion_title  = null;

        $cat_key            = null;
        $subcat_key         = null;
        $keyID              = null;

        $cat_array  = array();
        array_push($cat_array, base64_decode($cat));

        $questions      = AskQuestion::orderBy('totalanswer','DESC');
        $questions      = $questions->whereIn('category_id', $cat_array);
        $setCategory    = $cat_array;

        $items = BasicSetting::where('key', 'items_per_page')->first();
        if($items){
            $items = $items->value;
        }else{
            $items = 5;
        }
        $categorys          = Category::where('id',base64_decode($cat))->first();
        $setquestion_title  = $categorys->name;
        $cat_key            = 1;
        $keyID              = $cat;

        $questions_all = $questions->where(['question_label'=>'General','is_deleted'=>'0'])->paginate($items);
        return view('frontend.questions',compact('questions_all','setCategory','setSubcategory','settime','settag','setactivity','setquestion_title' , 'cat_key','subcat_key' , 'keyID'));
    }

    public function change_type($id){
        $ask = AskQuestion::where('id', base64_decode($id))->first();
        $ask->question_label="General";
        $ask->save();
        return response()->json([
            'statusText' => 'Success',
        ]);
    }

    public function image_upload(Request $request) {
        $accepted_origins = array("http://localhost", "https://thesageboard.com", "http://thesageboard.com");

        if($request->hasFile('file')) {
            $file                       = $request->file;
            $originalfile               = $file->getClientOriginalName();
            $rootfilename               = pathinfo($originalfile, PATHINFO_FILENAME);
            $filenameExntension         = $file->getClientOriginalExtension();
            $newfilename                = $rootfilename.'_'.time().'.'.$filenameExntension;
            $destinationPath            = public_path('details');
            $newfilelocation            = $destinationPath.DIRECTORY_SEPARATOR.$newfilename;

            // call intervention image class
            $image                      = Image::make($file->getRealPath());
            $imagewidth                 = $image->width();
            $imageheight                = $image->height();
            $imagesize                  = $image->filesize();
            $maxwidth                   = 900;
            $maxheight                  = 350;

            if($imagewidth > $maxwidth || $imageheight > $maxheight || $imagesize > 5242880) {
                $resizedimage = $image->resize($maxwidth, $maxheight, function($constraint) {
                    $constraint->aspectRatio();
                })->save($newfilelocation);
            } else {
                $file->move($destinationPath, $newfilename);
            }
            echo json_encode(array('location' => asset('public/details/'.$newfilename)));
        } else {
            echo header("HTTP/1.1 400 Please select image.");
        }
    }

    public function question_details($id){
        $question_details =  AskQuestion::where('id',base64_decode($id))->first();
        if($question_details && $question_details->is_deleted==0 && $question_details->question_label=='General'){
            $question_details->totalview = $question_details->totalview+1;
            $question_details->save();
            return view('frontend.single_question', compact('question_details'));
        }else{
            flash('Invalid Question Details')->error();
            return back();
        }
    }

    public function private_question_details($qid,$uid){
        $question_details = AskQuestion::where(['id'=> base64_decode($qid)])->first();
        if(base64_decode($uid)== Auth::user()->id){
            $question_details->viewed = '1';
            $question_details->save();
        }
        if($question_details && $question_details->is_deleted==0 && $question_details->question_label=='Premium'){
            $chats =  ChatRoom::where(['question_id'=>base64_decode($qid) , 'user_one_id'=>$question_details->user_id ,'user_two_id'=>base64_decode($uid)])->first();
            if($chats){
                $answer = Answer::where('unicode',$chats->unicode)->get();
                $accept_answer = $chats->accepted;
                $ctid = $chats->unicode;
            }else{
                $answer = Answer::where('unicode',"0000")->get();
                $accept_answer = 'no';
                $ctid = 'nai';
            }
            return view('frontend.private_single_question', compact('question_details','answer','uid','accept_answer','ctid'));
        }else{
            flash('Invalid Question Details')->error();
            return back();
        }

    }

    public function edit_question(Request $request,$id){
        if(!$_POST){
            $question  = AskQuestion::where('id', base64_decode($id))->first();
            return view('frontend.user.edit_question',compact('question'));
        }else{
            $questions =  AskQuestion::findOrFail(base64_decode($id));
            $questions->description = $request->description;
            if($questions->save()){
                flash('Changes Saved')->success();
                return back();
            }else{
                flash('Something went wrong')->error();
                return back();
            }
        }
    }

    public function edit_answer(Request $request,$id){
        if(!$_POST){
            $answer  = Answer::where('id', base64_decode($id))->first();
            $question  = AskQuestion::where('id', $answer->question_id)->first();
            return view('frontend.user.edit_answer',compact('answer','question'));
        }else{
            $answer=  Answer::findOrFail(base64_decode($id));
            $answer->answer = $request->answer;
            if($answer->save()){
                flash('Changes Saved')->success();
                return back();
            }else{
                flash('Something went wrong')->error();
                return back();
            }
        }
    }

    public function get_edit_answer($id){
        $answer  = Answer::where('id', base64_decode($id))->first();
        return view('frontend.partial.edit_answer',compact('answer'));
    }

    public function generateArticleslug($title, $id = 0)
    {
        $slug = Str::slug($title);
        $createSlugsAll = $this->getRelatedSlugs($slug, $id);
        if (! $createSlugsAll->contains('slug', $slug)){
            return $slug;
        }
        for ($i = 1; $i <= 10; $i++) {
            $makeSlug = $slug.'-'.$i;
            if (! $createSlugsAll->contains('slug', $makeSlug)) {
                return $makeSlug;
            }
        }
        throw new Exception('Can not generate a unique slug');
    }

    protected function getRelatedSlugs($slug, $id = 0)
    {
        return AskQuestion::select('slug')->where('slug', 'like', $slug.'%')->where('id', '<>', $id)->get();
    }

    public function createAllSlug($id){
        $allask = AskQuestion::where('id', $id)->first();
        $allask->slug  = $this->generateArticleslug($allask->question_title);
        $allask->save();
        flash('Add Successfull Slug')->success();
    }

    public function keySearch(Request $request){
        $datas =  DB::select('call getKeySearch(?)', [$request->data]);
        $searchItem = $request->data;
        return view('frontend.partial.search' , compact('datas','searchItem'));
    }


    public function  filter_title($title){

        $settime=null;
        $settag=null;
        $setactivity=null;
        $setquestion_title=null;
        $cat_key = null;
        $subcat_key = null;
        $keyID = null;


        $questions = AskQuestion::where('question_title' , 'Like','%'.$title.'%');
        $items = BasicSetting::where('key', 'items_per_page')->first();
        if($items){
            $items = $items->value;
        }else{
            $items = 5;
        }

        $setquestion_title = $title;
        $questions_all = $questions->where(['question_label'=>'General','is_deleted'=>'0'])->paginate($items);
        return view('frontend.questions',compact('questions_all','settime','settag','setactivity','setquestion_title','cat_key','subcat_key','keyID'));
    }

    public function  filter_topic($id){
        $settime=null;
        $settag=null;
        $setactivity=null;
        $setquestion_title=null;
        $cat_key = 1;
        $subcat_key = null;
        $keyID = $id;
        $questions = AskQuestion::where('category_id' , base64_decode($id));
        $items = BasicSetting::where('key', 'items_per_page')->first();
        if($items){
            $items = $items->value;
        }else{
            $items = 5;
        }

        $categorys = Category::where('id',base64_decode($id))->first();
        $setquestion_title = $categorys->name;
        $questions_all = $questions->where(['question_label'=>'General','is_deleted'=>'0'])->paginate($items);
        return view('frontend.questions',compact('questions_all','settime','settag','setactivity','setquestion_title','cat_key','subcat_key','keyID'));
    }

    public function  filter_subtopic($id){

        $settime=null;
        $settag=null;
        $setactivity=null;
        $setquestion_title=null;
        $cat_key = null;
        $subcat_key = 1;
        $keyID = $id;

        $questions = AskQuestion::where('subcategory_id' , base64_decode($id));
        $items = BasicSetting::where('key', 'items_per_page')->first();
        if($items){
            $items = $items->value;
        }else{
            $items = 5;
        }

        $subcat= SubCategory::where('id',base64_decode($id))->first();
        $setquestion_title = $subcat->name;
        $questions_all = $questions->where(['question_label'=>'General','is_deleted'=>'0'])->paginate($items);
        return view('frontend.questions',compact('questions_all','settime','settag','setactivity','setquestion_title','cat_key','subcat_key','keyID'));
    }

    public function notifyComment($qid , $notifyUser , $title , $type){
        $not =  new Notify();
        $not->create_user_id = Auth::user()->id;
        $not->question_id = $qid;
        $not->notify_user_id = $notifyUser;
        $not->notify_title = $title;
        $not->type = $type;
        $not->save();
    }

    public function isertForTopic($topicId, $qsnId , $subtopicId){
        $qsntitle = AskQuestion::where('id', $qsnId)->select('question_title')->first();
        $value = Str::limit($qsntitle->question_title, 50);

        $expertise_area  =  UserDetails::whereNotIn('user_id', array(Auth::user()->id))->whereRaw('JSON_SEARCH(expert_category, "one","'.$topicId.'") IS NOT NULL');
        $topic   =  $expertise_area->whereRaw('JSON_SEARCH(expert_subcategory, "one","'.$subtopicId.'") IS NOT NULL')->distinct()->get('user_id');
        $data = [];
        foreach ($topic as $topic) {
            $data[] = [
                'create_user_id'  => Auth::user()->id,
                'question_id'     => $qsnId,
                'notify_user_id'   => $topic->user_id,
                'notify_title'     => $value,
                'type'             => '10',
                'created_at'       => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ];
        }
        Notify::insert($data);
    }

    public function isertForrelatedTopic($topicId, $qsnId , $subtopicId){
        $qsntitle = AskQuestion::where('id', $qsnId)->select('question_title')->first();
        $value = Str::limit($qsntitle->question_title, 50);
        $topic = AskQuestion::where(['category_id'=> $topicId])->orWhere(['subcategory_id'=> $subtopicId])->distinct()->get('user_id');
        $data = [];
        foreach ($topic as $topic) {
            if(Auth::user()->id!=$topic->user_id){
                $data[] = [
                    'create_user_id'  => Auth::user()->id,
                    'question_id'     => $qsnId,
                    'notify_user_id'   => $topic->user_id,
                    'notify_title'     => $value,
                    'type'             => '10',
                    'created_at'       => date('Y-m-d H:i:s'),
                    'updated_at'         => date('Y-m-d H:i:s'),
                ];
            }
        }
        Notify::insert($data);
    }

}
