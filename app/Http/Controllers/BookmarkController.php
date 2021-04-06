<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class BookmarkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response=[];
        try {
            $bookmarks = Bookmark::with('recipe','user')->get();
            $response["bookmarks"] = $bookmarks;
            $response["code"] = 200;
        }catch(\Exception $e) {
            $response["errors"] = ["message"=>"Unable to get the bookmarks! $e"];
            $response["code"] = 400;
        }
        return response($response, $response["code"]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validation here
        $validation = Validator::make($request->all(),[
            'user_id' => "required",
            'recipe_id' =>'required'
        ]);

        $response =[];
        if($validation->fails()){
            $response["errors"] = $validation->errors();
            $response["code"] = 400;
        }else {
            DB::beginTransaction();
            try{
                $bookmark = Bookmark::create($request->all());
                DB::commit();
                $response["last_inserted_id"] = $bookmark->id;
                $response["code"] = 200;
            }catch(\Exception $e) {
                DB::rollBack();
                $response["errors"] = ["message"=>"Cannot add bookmark! $e"];
                $response["code"] = 400;
            }

            return response($response, $response["code"]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bookmark  $Bookmark
     * @return \Illuminate\Http\Response
     */
    public function show(Bookmark $Bookmark)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bookmark  $Bookmark
     * @return \Illuminate\Http\Response
     */
    public function edit(Bookmark $Bookmark)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bookmark  $Bookmark
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bookmark $Bookmark)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bookmark  $Bookmark
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        $response=[];
        try {
            $bookmark = Bookmark::findOrFail($id)->delete();
            DB::commit();
            $response["last_deleted_id"] = $id;
            $response["code"] = 200;
        }catch(\Exception $e) {
            DB::rollBack();
            $response["errors"] = ["message"=> "Unable to delete this bookmark $e"];
            $response["code"] = 400;
        }
        
        return response($response, $response["code"]);
    }
}
