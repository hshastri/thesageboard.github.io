<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use App\InviteUser;
use App\UserDetails;
use Illuminate\Http\Request;
use Hash;
use App\User;
class InviteUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = InviteUser::where('type','User')->orderBy('created_at', 'desc')->get();
        return view("crm.invite.index", compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("crm.invite.invite");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_email = User::where('email', $request->email)->first();
        $user_invite_email = InviteUser::where('email', $request->email)->first();
        if($user_email || $user_invite_email){
            flash('Email Already Exits Choose New One')->error();
            return back();
        }else{

            $users = new InviteUser();
            $users->first_name = $request->first_name;
            $users->last_name  = $request->last_name;
            $users->email      = $request->email;
            $users->password   = Hash::make('123456');
            $users->role      = $request->role;
            if($users->save()){
                flash('Invitation Send successfully')->success();
                return redirect()->route('invite.index');
            }
            else{

                flash('Something went wrong')->error();
                return back();
            }
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
        $users = InviteUser::findOrFail(base64_decode($id));
        return view("crm.invite.update", compact('users'));
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
        $inviteusers = InviteUser::findOrFail(base64_decode($id));
        if($request->status=="Active"){
            $users = new User();
            $users->first_name = $request->first_name;
            $users->last_name  = $request->last_name;
            $users->email      = $request->email;
            $users->password   = Hash::make('123456');
            $users->role      = $request->role;
            if($users->save()){
                $user_details = new  UserDetails();
                $user_details->user_id = $users->id;
                $user_details->save();
                InviteUser::destroy(base64_decode($id));
                flash($request->first_name.' '.$request->last_name .' Added User list successfully')->success();
                return redirect()->route('invite.index');
            }
            else{

                flash('Something went wrong')->error();
                return back();
            }
        }else{
            $inviteusers->first_name = $request->first_name;
            $inviteusers->last_name  = $request->last_name;
            $inviteusers->email      = $request->email;
            $inviteusers->role      = $request->role;
            if($inviteusers->save()){
                flash('User has been Updated successfully')->success();
                return redirect()->route('invite.index');
            }
            else{

                flash('Something went wrong')->error();
                return back();
            }
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
        if(InviteUser::destroy(base64_decode($id))){
            flash('User has been deleted successfully')->success();
            return redirect()->route('invite.index');
        }
        else{
            flash('Something went wrong')->error();
            return back();
        }
    }

    public function reinvite($id){
        $users = InviteUser::findOrFail(base64_decode($id));
        if($users){
            flash('Send Invitation Again To ' . $users->email)->success();
            return redirect()->route('invite.index');
        }
        else{
            flash('Something went wrong')->error();
            return back();
        }
    }
}
