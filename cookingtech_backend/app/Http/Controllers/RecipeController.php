<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Validator;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //retrive all recipes

        $recipe = Recipe::all();
        return response()->json($recipe);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $recipe = new Recipe();
        $recipe->name = $request->name;
        $recipe->description =$request->description;
        $recipe->tag=$request->tag;
        $recipe->category= $request->category;
        $recipe->yield= $request->yield;
        $recipe->video= $request->video;
        $recipe->img= $request->img;
        $recipe->ingredients =$request->ingredients;
        $recipe->procedure= $request->procedure;
        $recipe->save();

        return response()->json($recipe);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function show(Recipe $recipe)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function edit(Recipe $recipe)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        //
        $recipe = Recipe::find($id);
        $recipe->name = $request->name;
        $recipe->description =$request->description;
        $recipe->tag=$request->tag;
        $recipe->category= $request->category;
        $recipe->yield= $request->yield;
        $recipe->video= $request->video;
        $recipe->img= $request->img;
        $recipe->ingredients =$request->ingredients;
        $recipe->procedure= $request->procedure;
        $recipe->save();

        return response()->json($recipe);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $recipe = Recipe::find($id);
        $recipe->delete();

        return response()->json($recipe);
    }

    public function searchById($id){
        $recipe = Recipe::find($id);
        return response()->json($recipe);
    }

    // public function searchbyTag($tag){
    //     $data =$request->get('tag');

    //     $recipe =Driver::where('tag','like',"%{$data}%")->get();
    //     return response()->json(['data' => $recipe]);
    // }
//testing 
    function testData(Request $request){
        $rules=array(
            "name"=>"required"

        );

        $validator= Validator::make($request->all(),$rules);
        if($validator->fails()){
            return $validator->errors();
        }
    }

   
}
