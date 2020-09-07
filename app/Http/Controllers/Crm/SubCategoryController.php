<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use App\Question;
use App\SubCategory;
use App\Category;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subcategory = SubCategory::orderBy('created_at', 'desc')->get();
        return view("crm.subcategory.index",compact('subcategory'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::where('status','Active')->orderBy('created_at', 'desc')->get();
        return view("crm.subcategory.create", compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $subcategory = new SubCategory();
        $subcategory->name = $request->name;
        $subcategory->category_id = $request->category_id;
        $subcategory->status = $request->status;
        if($subcategory->save()){
            flash('Subcategory has been inserted successfully')->success();
            return redirect()->route('subcategory.index');
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

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subcategory = SubCategory::findOrFail(base64_decode($id));
        $category = Category::orderBy('created_at', 'desc')->get();
        return view("crm.subcategory.update", compact('subcategory', 'category'));
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
        $subcategory = SubCategory::findOrFail(base64_decode($id));
        $subcategory->name = $request->name;
        $subcategory->category_id = $request->category_id;
        $subcategory->status = $request->status;
        if($subcategory->save()){
            flash('Subcategory has been updated successfully')->success();
            return redirect()->route('subcategory.index');
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
        $subcategory = SubCategory::findOrFail(base64_decode($id));
        Question::where('subcategory_id', $subcategory->id)->delete();
        if(SubCategory::destroy(base64_decode($id))){
            flash('Subcategory has been deleted successfully')->success();
            return redirect()->route('subcategory.index');
        }
        else{
            flash('Something went wrong')->error();
            return back();
        }
    }
}
