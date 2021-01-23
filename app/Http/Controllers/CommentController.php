<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class CommentController extends Controller
{
    /**
     * return a listing of the Comments.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response=[];
        try {
            $comments = Comment::all();
            $response["comments"] = $comments;
            $response["code"] = 200;
        }catch(\Exception $e) {
            $response["errors"] = ["message"=> "Unable to get users $e"];
            $response["code"] = 400;
        }

        return response($response, $response["code"]);
    }

    /**
     * Store a newly created Comment in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //validation here
        $validation = Validator::make($request->all(),[
            'content' =>'required',
            'user_id' => 'required',
            'recipe_id' => 'required'
        ]);
        
        $response=[];
        
        if($validation->fails()){
            $response["errors"] = $validation->errors();
            $response["code"] = 400;
        }else {
            DB::beginTransaction();
            try{
                //save
                $comment = Comment::create($request->all());

                DB::commit();
                $response["last_inserted_id"] = $comment->id;
                $response["code"] = 200;
            }catch(\Exception $e) {
                DB::rollBack();
                $response["errors"] = ["message" => "Unable to retrieve save comment! $e"];
                $response["code"] = 400;
            }
        }
        return response($response, $response["code"]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response=[];
        DB::beginTransaction();
        try{
            $comment = Comment::findOrFail($id)->delete();
            DB::commit();
            $response["last_deleted_id"] = $id;
            $response["code"] = 200;
        }catch(\Exception $e) {
            DB::rollBack();
            $response["errors"] = ["message"=> "Unable to delete comment $e"];
            $response["code"] = 400;
        }

        return response($response, $response["code"]);
    }
}
