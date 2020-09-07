<?php

namespace App\Http\Controllers\Crm;

use App\AskQuestion;
use App\Category;
use App\Http\Controllers\Controller;
use App\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $question = Question::orderBy('created_at', 'desc')->get();
        return view("crm.question.index",compact('question'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::where('status','Active')->orderBy('created_at', 'desc')->get();
        return view("crm.question.create", compact( 'category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $question = new Question();
        $question->category_id = $request->category_id;
        $question->subcategory_id = $request->subcategory_id;
        $question->question = $request->question;
        $question->type = $request->type;
        $question->multiple_question = json_encode($request->multiple_question);
        $question->status = $request->status;
        if($question->save()){
            flash('Question has been inserted successfully')->success();
            return redirect()->route('question.index');
        }
        else{

            flash('Something went wrong')->error();
            return back();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $question = Question::findOrFail(base64_decode($id));
        $category = Category::where('status','Active')->orderBy('created_at', 'desc')->get();
        return view("crm.question.update", compact( 'question','category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $question = Question::findOrFail(base64_decode($id));
        $question->category_id = $request->category_id;
        $question->subcategory_id = $request->subcategory_id;
        $question->question = $request->question;
        $question->type = $request->type;
        $question->multiple_question =($request->type==3)?'':json_encode($request->multiple_question);
        $question->status = $request->status;
        if($question->save()){
            flash('Question has been update successfully')->success();
            return redirect()->route('question.index');
        }
        else{

            flash('Something went wrong')->error();
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Question::destroy(base64_decode($id))){
            flash('Question has been deleted successfully')->success();
            return redirect()->route('question.index');
        }
        else{
            flash('Something went wrong')->error();
            return back();
        }
    }

    public function ask_question()
    {
        $questions = AskQuestion::orderBy('created_at', 'desc')->get();
        return view("crm.question.ask_question",compact('questions'));
    }

    public function ask_question_details($id)
    {
        $askquestion = AskQuestion::findOrFail(base64_decode($id));
        return view("crm.question.question_detail",compact('askquestion'));
    }

    public function soft_delete($id)
    {
        $askquestion = AskQuestion::where('id',base64_decode($id))->first();
        $askquestion->is_deleted="1";
        $askquestion->save();
        flash('Question has been deleted successfully')->success();
        return redirect()->route('crm.ask-question');

    }


}
