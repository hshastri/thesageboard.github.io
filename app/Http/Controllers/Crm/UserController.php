<?php

namespace App\Http\Controllers\Crm;

use App\Answer;
use App\AskQuestion;
use App\Http\Controllers\Controller;
use App\Question;
use Illuminate\Http\Request;
use App\User;
use Hash;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('type','User')->orderBy('created_at', 'desc')->get();
        return view("crm.user.index", compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("crm.user.invite");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

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
        $users = User::findOrFail(base64_decode($id));
        return view("crm.user.update", compact('users'));
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
        $users = User::findOrFail(base64_decode($id));
        $users->first_name = $request->first_name;
        $users->last_name  = $request->last_name;
        $users->email      = $request->email;
        $users->role      = $request->role;
        $users->status    = $request->status;
        if($users->save()){
            flash('User has been Updated successfully')->success();
            return redirect()->route('users.index');
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
        $question  = AskQuestion::where('user_id', base64_decode($id))->first();
        if($question){
            flash('User Can not Delete')->error();
            return back();
        }
        $answer  = Answer::where('user_id', base64_decode($id))->first();
        if($answer){
            flash('User Can not Delete')->error();
            return back();
        }
        if(User::destroy(base64_decode($id))){
            UserDetails::where('user_id', base64_decode($id))->delete();
            flash('User has been deleted successfully')->success();
            return redirect()->route('users.index');
        }
        else{
            flash('Something went wrong')->error();
            return back();
        }
    }

    public function reinvite($id){
        $users = User::findOrFail(base64_decode($id));
        $users->invitation = "Send";
        if($users->save()){
            flash('Invitation Send successfully')->success();
            return redirect()->route('users.index');
        }
        else{
            flash('Something went wrong')->error();
            return back();
        }
    }
}
