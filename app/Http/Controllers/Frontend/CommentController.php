<?php

namespace App\Http\Controllers\Frontend;

use App\AskQuestion;
use App\Comment;
use App\Http\Controllers\Controller;
use App\Notify;
use App\QuestionChildComment;
use App\QuestionComment;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Str;

class CommentController extends Controller
{
    public function unseen(){
        $notify = Notify::where(['notify_user_id' => Auth::user()->id , 'seen'=>'0'])->count();
        return response()->json([
            'cnt' => $notify,
        ]);
    }

    public function getNotifydata(){
        $nots = Notify::where(['notify_user_id' => Auth::user()->id])->update(['seen' => 1]);
        $notification = Notify::where(['notify_user_id' => Auth::user()->id,'status'=>'0'])->orderBy('id', 'desc')->take(10)->get();
        return view('frontend.partial.notifylist' , compact('notification'));
    }

    public function readNotification($id){
        $notie = Notify::where(['id' => $id])->first();
        $notie->is_read = 1;
        $notie->save();
    }

    public function load_question_comment($id){
        $comment = QuestionComment::where('question_id', base64_decode($id))->get();
        return view('frontend.partial.question_comment', compact('comment','id'));
    }

    public function add_question_comment(Request $request , $id){
        if(!$request->questioncomment){
            return response()->json([
                'message' => 'Fail',
                'status' => '400',
            ]);
        }
        $comment = new QuestionComment();
        $comment->question_id= base64_decode($id);
        $comment->user_id = Auth::user()->id;
        $comment->comment = $request->questioncomment;
        if($comment->save()){
            $question_user = AskQuestion::where('id', base64_decode($id))->first();
            if(Auth::user()->id != $question_user->user_id){
                $value = Str::limit($request->questioncomment, 50);
                $this->notifyComment(base64_decode($id), $question_user->user_id , $value);
            }
            return response()->json([
                'message' => 'Success',
                'status' => '200',
            ]);
        }else{
            return response()->json([
                'message' => 'Fail',
                'status' => '400',
            ]);
        }
    }
    public function add_question_child_comment(Request $request , $id){

        if(!$request->questionchildcomment){
            return response()->json([
                'message' => 'Fail',
                'status' => '400',
            ]);
        }
        $comment = new QuestionChildComment();
        $comment->comment_id = base64_decode($id);
        $comment->user_id = Auth::user()->id;
        $comment->comment = $request->questionchildcomment;
        if($comment->save()){
            $value = Str::limit($request->questionchildcomment, 50);

           /* $child_user = QuestionComment::where('id', base64_decode($id))->first();
            if(Auth::user()->id != $child_user->user_id){
                $this->notifyComment($child_user->question_id, $child_user->user_id , $value);

            }

            $qsn_id = AskQuestion::where('id', $child_user->question_id)->first();
            if(Auth::user()->id != $child_user->user_id){
                $this->notifyComment($qsn_id->id, $qsn_id->user_id, $value);
            }*/


            return response()->json([
                'message' => 'Success',
                'status' => '200',
            ]);
        }else{
            return response()->json([
                'message' => 'Fail',
                'status' => '400',
            ]);
        }
    }
    public function add_question_sub_child_comment(Request $request , $id){

        if(!$request->questionSubChildComment){
            return response()->json([
                'message' => 'Fail',
                'status' => '400',
            ]);
        }
        $comment = new QuestionChildComment();
        $comment->parent_id = base64_decode($id);
        $comment->user_id = Auth::user()->id;
        $comment->comment = $request->questionSubChildComment;
        if($comment->save()){
            return response()->json([
                'message' => 'Success',
                'status' => '200',
            ]);
        }else{
            return response()->json([
                'message' => 'Fail',
                'status' => '400',
            ]);
        }
    }

    public function edit_question_child_comment(Request $request , $id){
        if(!$request->commentEdit){
            return response()->json([
                'message' => 'Fail',
                'status' => '400',
            ]);
        }
        $qsn_edit = QuestionComment::where('id', $id)->first();
        $qsn_edit->comment = $request->commentEdit;
        if($qsn_edit->save()){
            return response()->json([
                'message' => 'Success',
                'status' => '200',
            ]);
        }else{
            return response()->json([
                'message' => 'Fail',
                'status' => '400',
            ]);
        }
    }
    public function edit_sub_child_comment(Request $request , $id){
        if(!$request->commentEdit){
            return response()->json([
                'message' => 'Fail',
                'status' => '400',
            ]);
        }
        $qsn_edit = QuestionChildComment::where('id', $id)->first();
        $qsn_edit->comment = $request->commentEdit;
        if($qsn_edit->save()){
            return response()->json([
                'message' => 'Success',
                'status' => '200',
            ]);
        }else{
            return response()->json([
                'message' => 'Fail',
                'status' => '400',
            ]);
        }
    }
    public function edit_question_child_sub_comment(Request $request , $id){
        if(!$request->commentEdit){
            return response()->json([
                'message' => 'Fail',
                'status' => '400',
            ]);
        }
        $qsn_edit = QuestionChildComment::where('id', $id)->first();
        $qsn_edit->comment = $request->commentEdit;
        if($qsn_edit->save()){
            return response()->json([
                'message' => 'Success',
                'status' => '200',
            ]);
        }else{
            return response()->json([
                'message' => 'Fail',
                'status' => '400',
            ]);
        }
    }

    public function delete_qsn_child_comment($id){
        $count= 0;
        $qsn_child = QuestionComment::where('id', base64_decode($id))->first();
        if($qsn_child){
            $parent_child = QuestionChildComment::where('comment_id', base64_decode($id))->first();
            if($parent_child){
                $count =  QuestionChildComment::where('comment_id', base64_decode($id))->count();
                $parent_child->delete();
            }
            $count = $count + QuestionComment::where('id', base64_decode($id))->count();
            $qsn_child->delete();
            return response()->json([
                'message' => 'Success',
                'status' => '200',
                'count' => $count,
            ]);
        }
    }
    public function delete_qsn_sub_comment($id){
        $count= 0;
        $parent_child = QuestionChildComment::where('id', base64_decode($id))->first();
        if($parent_child){
            $count =  QuestionChildComment::where('id', base64_decode($id))->count();
            $parent_child->delete();
        }
        $count = $count + QuestionComment::where('id', base64_decode($id))->count();

        return response()->json([
            'message' => 'Success',
            'status' => '200',
            'count' => $count,
        ]);
    }
    public function delete_qsn_sub_child_comment($id){
        $count= 0;
        $parent_child = QuestionChildComment::where('id', base64_decode($id))->first();
        if($parent_child){
            $count =  QuestionChildComment::where('id', base64_decode($id))->count();
            $parent_child->delete();
        }
        return response()->json([
            'message' => 'Success',
            'status' => '200',
            'count' => $count,
        ]);
    }


    public function load_ans_comment($id){
        $comment = Comment::where('answer_id', base64_decode($id))->get();
        return view('frontend.partial.answer_comment', compact('comment','id'));
    }
    public function add_ans_child_comment(Request $request,$id , $ansId){

        if(!$request->ansChildComment){
            return response()->json([
                'message' => 'Fail',
                'status' => '400',
            ]);
        }
        $comment = new Comment();
        $comment->parent_id = base64_decode($id);
        $comment->user_id = Auth::user()->id;
        $comment->comment = $request->ansChildComment;
        if($comment->save()){

            /*$value = Str::limit($request->ansChildComment, 50);
            $this->notifyComment(base64_decode($id), $question_user->user_id , $value);*/

            return response()->json([
                'message' => 'Success',
                'status' => '200',
                'ansID' => $ansId,
                'route' => route('load-ans-comment',base64_encode($ansId)),
            ]);
        }else{
            return response()->json([
                'message' => 'Fail',
                'status' => '400',
            ]);
        }
    }

    public function edit_ans_child_comment(Request $request, $id ){
        if(!$request->commentEdit){
            return response()->json([
                'message' => 'Fail',
                'status' => '400',
            ]);
        }
        $comment_edit = Comment::where('id', $id)->first();
        $comment_edit->comment = $request->commentEdit;
        if($comment_edit->save()){
            return response()->json([
                'message' => 'Success',
                'status' => '200',
                'ansID' => $comment_edit->answer_id,
                'route' => route('load-ans-comment',base64_encode($comment_edit->answer_id)),
            ]);
        }else{
            return response()->json([
                'message' => 'Fail',
                'status' => '400',
            ]);
        }
    }
    public function edit_ans_subchild_comment(Request $request, $id ){
        if(!$request->commentEdit){
            return response()->json([
                'message' => 'Fail',
                'status' => '400',
            ]);
        }
        $comment_edit_child = Comment::where('id', $id)->first();
        $ans_id = Comment::where('id', $comment_edit_child->parent_id)->first();
        $comment_edit_child->comment = $request->commentEdit;
        if($comment_edit_child->save()){
            return response()->json([
                'message' => 'Success',
                'status' => '200',
                'ansID' => $ans_id->answer_id,
                'route' => route('load-ans-comment',base64_encode($ans_id->answer_id)),
            ]);
        }else{
            return response()->json([
                'message' => 'Fail',
                'status' => '400',
            ]);
        }
    }
    public function edit_sub_subchild_comment(Request $request, $id ){
        if(!$request->commentEdit){
            return response()->json([
                'message' => 'Fail',
                'status' => '400',
            ]);
        }
        $comment_edit_sub_child = Comment::where('id', $id)->first();
        $parent_id = Comment::where('id', $comment_edit_sub_child->parent_id)->first();
        $ans_id = Comment::where('id', $parent_id->parent_id)->first();

        $comment_edit_sub_child->comment = $request->commentEdit;
        if($comment_edit_sub_child->save()){
            return response()->json([
                'message' => 'Success',
                'status' => '200',
                'ansID' => $ans_id->answer_id,
                'route' => route('load-ans-comment',base64_encode($ans_id->answer_id)),
            ]);
        }else{
            return response()->json([
                'message' => 'Fail',
                'status' => '400',
            ]);
        }
    }

    public function delete_ans_child_comment($id){
        $count= 0;
        $comment_child = Comment::where('id', base64_decode($id))->first();
        $ans_id = $comment_child->answer_id;
        if($comment_child){
            $parent_child = Comment::where('parent_id', base64_decode($id))->first();
            if($parent_child){
                $count =  Comment::where('parent_id', base64_decode($id))->count();
                $parent_child->delete();
            }
            $count = $count + Comment::where('id', base64_decode($id))->count();
            $comment_child->delete();
            return response()->json([
                'message' => 'Success',
                'status' => '200',
                'ansID' => $ans_id,
                'route' => route('load-ans-comment',base64_encode($ans_id)),
                'count' => $count,
            ]);
        }

    }
    public function delete_ans_sub_child_comment($id){
        $count= 0;
        $comment_sub_child = Comment::where('id', base64_decode($id))->first();
        $ans_id = Comment::where('id', $comment_sub_child->parent_id)->first();
        if($comment_sub_child){
            $count =  Comment::where('id', base64_decode($id))->count();
            $comment_sub_child->delete();
            return response()->json([
                'message' => 'Success',
                'status' => '200',
                'ansID' => $ans_id->answer_id,
                'route' => route('load-ans-comment',base64_encode($ans_id->answer_id)),
                'count' => $count,
            ]);
        }
    }
    public function delete_sub_sub_child_comment($id){
        $count= 0;
        $comment_del_sub_child = Comment::where('id', base64_decode($id))->first();
        $parent_id = Comment::where('id', $comment_del_sub_child->parent_id)->first();
        $ans_id = Comment::where('id', $parent_id->parent_id)->first();

        if($comment_del_sub_child){
            $count =  Comment::where('id', base64_decode($id))->count();
            $comment_del_sub_child->delete();
            return response()->json([
                'message' => 'Success',
                'status' => '200',
                'ansID' => $ans_id->answer_id,
                'route' => route('load-ans-comment',base64_encode($ans_id->answer_id)),
                'count' => $count,
            ]);
        }
    }


    public function notifyComment($qid , $notifyUser , $title){
        $not =  new Notify();
        $not->create_user_id = Auth::user()->id;
        $not->question_id = $qid;
        $not->notify_user_id = $notifyUser;
        $not->notify_title = $title;
        $not->type = 6;
        $not->save();
    }



}
