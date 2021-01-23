<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        try {
            $recipe = Recipe::all();
            return response()->json($recipe);
        } catch (\Exception $e) {
            return response()->json($e);
        }

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
        //validation
        $validation = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'description' => 'required|max:255',
            'tag' => 'required',
            'category' => 'required',
            'yield' => 'required',
            'video_url' => 'required',
            'img_url' => 'required',
            'ingredients' => 'required',
            'procedures' => 'required',
            'user_id' => 'required',

        ]);

        $response = [];

        //check the validation if there are errors

        if ($validation->fails()) {
            $response["errors"] = $validation->errors();
            $response["code"] = 400;
        } else {
            DB::beginTransaction();
            try {
                //save
                $data = $request->all();
                $data["status"] = false;
                $recipe = Recipe::create($request->all());
                DB::commit();
                $response["last_inserted_id"] = $recipe->id;
                $response["code"] = 200;
            } catch (\Exception $e) {
                DB::rollback();
                $response["errors"] = ["message" => "Recipe is not created" . $e];
                $response["code"] = 400;
            }
        }
        return response($response, $response["code"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *vpp\Models\Recipe  $recipe
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
    public function update(Request $request, $id)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'description' => 'required|max:255',
            'tag' => 'required',
            'category' => 'required',
            'yield' => 'required',
            'video_url' => 'required',
            'img_url' => 'required',
            'ingredients' => 'required',
            'procedures' => 'required',
            'user_id' => 'required',
        ]);

        $response = [];

        //check the validation if there are errors

        if ($validation->fails()) {
            $response["errors"] = $validation->errors();
            $response["code"] = 400;
        } else {
            DB::beginTransaction();
            try {
                $recipe = Recipe::where("id", $id)
                    ->update($request->all());
                    
                DB::commit();
                $response["last_updated_id"] = $id;
                $response["code"] = 200;
            } catch (\Exception $e) {
                DB::rollback();
                $response["errors"] = ["Recipe is not updated" . $e];
                $response["code"] = 400;
            }
        }
        return response($response, $response["code"]);
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
        $response = [];
        DB::beginTransaction();
        try {
            $recipe = Recipe::find($id)
                ->delete($id);
            DB::commit();
            $response["last_id_deleted"] = $id;
            $response["code"] = 200;
        } catch (\Exception $e) {
            DB::rollback();
            $response["error"] = ["Failed to Delete" . $e];
            $response["code"] = 400;
        }
        return response($response, $response["code"]);
    }

    public function searchById($id)
    {
        $response = [];
        try {
            $recipe = Recipe::where('id',$id)
                ->with('comments','comments.replies')->get();
            $response["recipe"] = $recipe;
            $response["code"] = 200;
        } catch (\Exception $e) {
            $response["errors"] = "Cannot be found";
            $response["code"] = 400;
        }
        return response($response, $response["code"]);
    }

    //search by tag
    public function searchbyTag($tag)
    {
        $response = [];
        try {
            $recipe = Recipe::where('tag', 'like', "%{$tag}%")
                ->get();
            if (count($recipe) < 1) {
                throw new \Exception();
            }
            $response["tag"] = $recipe;
            $response["code"] = 200;
        } catch (\Exception $e) {
            $response["errors"] = "Tag doesn't match any recipe";
            $response["code"] = 400;
        }
        return response($response, $response["code"]);
    }

//search by category
    public function searchbyCategory($category)
    {
        $response = [];
        try {
            $recipe = Recipe::where("category", $category)
                ->get();
            if (count($recipe) < 1) {
                throw new \Exception();
            }
            $response["category"] = $recipe;
            $response["code"] = 200;
        } catch (\Exception $e) {
            $response["error"] = "Category not available";
            $response["code"] = 400;
        }
        return response($response, $response["code"]);
    }

}
