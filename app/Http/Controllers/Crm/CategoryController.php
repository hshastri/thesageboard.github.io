<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use App\Question;
use App\SubCategory;
use Illuminate\Http\Request;
use App\Category;
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::orderBy('created_at', 'desc')->get();
        return view("crm.category.index", compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("crm.category.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = new Category();
        $category->name = $request->name;
        $category->icon = $request->icon;
        $category->description = $request->description;
        $category->status = $request->status;
        if($category->save()){
            flash('Category has been inserted successfully')->success();
            return redirect()->route('category.index');
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
        $category = Category::findOrFail(base64_decode($id));
        return view("crm.category.update", compact('category'));
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
        $category = Category::findOrFail(base64_decode($id));
        $category->name = $request->name;
        $category->icon = $request->icon;
        $category->description = $request->description;
        $category->status = $request->status;
        if($category->save()){
            flash("Category has been updated successfully")->success();
            return redirect()->route('category.index');
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

        $category = Category::findOrFail(base64_decode($id));
        SubCategory::where('category_id', $category->id)->delete();
        Question::where('category_id', $category->id)->delete();
        if(Category::destroy(base64_decode($id))){

            flash('Category has been deleted successfully')->success();
            return redirect()->route('category.index');
        }
        else{
            flash('Something went wrong')->error();
            return back();
        }
    }


}
