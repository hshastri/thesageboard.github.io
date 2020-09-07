<?php

namespace App\Http\Controllers\Crm;

use App\Category;
use App\Http\Controllers\Controller;
use App\SubCategory;
use App\Tag;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags_all = Tag::orderBy('created_at', 'desc')->paginate(10);
        return view("crm.tag.index", compact('tags_all'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("crm.tag.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $tag = new Tag();
        $tag->tags = $request->tag;
        $tag->status = $request->status;
        if($tag->save()){
            flash('Tag has been inserted successfully')->success();
            return redirect()->route('tags.index');
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
        $tags = Tag::findOrFail(base64_decode($id));
        return view("crm.tag.update", compact('tags'));
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
        $tags = Tag::findOrFail(base64_decode($id));
        $tags->tags = $request->tag;
        $tags->status = $request->status;
        if($tags->save()){
            flash('Tag has been updated successfully')->success();
            return redirect()->route('tags.index');
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
        if(Tag::destroy(base64_decode($id))){
            flash('Tag has been deleted successfully')->success();
            return redirect()->route('tags.index');
        }
        else{
            flash('Something went wrong')->error();
            return back();
        }
    }

}
