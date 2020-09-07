<?php

namespace App\Http\Controllers\Crm;

use App\Badge;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BadgeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $badge = Badge::orderBy('created_at', 'desc')->get();
        return view("crm.badge.index", compact('badge'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("crm.badge.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $badge = new Badge();
        $badge->name = $request->name;
        $badge->score = $request->score;
        $badge->icon = $request->icon;
        if($badge->save()){
            flash('Badge has been inserted successfully')->success();
            return redirect()->route('badge.index');
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
        $badge = Badge::findOrFail(base64_decode($id));
        return view("crm.badge.update", compact('badge'));
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
        $badge = Badge::findOrFail(base64_decode($id));
        $badge->name = $request->name;
        $badge->score = $request->score;
        $badge->icon = $request->icon;
        if($badge->save()){
            flash("Badge has been updated successfully")->success();
            return redirect()->route('badge.index');
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
        if(Badge::destroy(base64_decode($id))){

            flash('BAdge has been deleted successfully')->success();
            return redirect()->route('badge.index');
        }
        else{
            flash('Something went wrong')->error();
            return back();
        }
    }
}
