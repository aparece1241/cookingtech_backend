<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Client\ResponseSequence;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {   
        $response =[];
        try {
            $users = User::all();
            $response["users"] = $users;
            $response["code"] = 200;
        } catch (\Exception $e) {
            $response["errors"] = ["message"=>"Unable to get all users ".$e];
            $response["code"] = 400;
        }

        return response($response, $response["code"]);
    }


    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'message' => ['This credential doesn\' match to our records!']
            ], 404);
        }

        $token = $user->createToken('my_app_token')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    /**
     * The store function will act as the register user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validation here
        $validation = Validator::make($request->all(), [
            'username' => 'required|unique:users|max:255',
            'firstname' => 'required',
            'lastname' => 'required',
            'password' => 'required',
            'email' => 'required|email|unique:users',
            'usertype' => 'required'
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
                $user = User::create($request->all());

                $response["last_inserted_id"] = $user->id;
                $response["code"] = 200;
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                $response["errors"] = ["message" => "The user was not created!". $e];
                $response["code"] = 400;
            }
        }
        return response($response, $response["code"]);
    }

    /**
     * get the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $response =[];
        try {
            $user = User::find($id);
            $response["code"] = 200;
            $response["user"] = $user;

        }catch(\Exception $e) {
            $response["errors"]=["message"=> "Unable to get the user!" . $e];
            $response["code"]= 400;
        }

        return response($response, $response["code"]);
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
         //validation here
        $validation = Validator::make($request->all(), [
            'username' => 'required|max:255',
            'firstname' => 'required',
            'lastname' => 'required',
            'password' => 'required',
            'email' => 'required|email',
            'usertype' => 'required'
        ]);
        $response = [];

        //check the validation if there are errors
        if ($validation->fails()) {
            $response["errors"] = $validation->errors();
            $response["code"] = 400;
        } else {
            DB::beginTransaction();
            // return $request->all();
            try {
                //update
                $user = User::where('id', $id)
                    ->update($request->all());
                
                $response["last_edited_id"] = $id;
                $response["code"] = 200;
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                $response["errors"] = ["message" => "The changes was'nt saved! .$e"];
                $response["code"] = 400;
            }
        }
        return response($response, $response["code"]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        $response = [];
        try {
            $user = User::findOrFail($id)->delete();
            DB::commit();
            $response["code"] = 200;
            $response["last_deleted_id"] = $id;
        }catch (\Exception $e) {
            DB::rollBack();
            $response["errors"] = ["message"=> "The user was'nt deleted!". $e];
            $response["code"] = 400;
        }

        return response($response, $response["code"]);
    }

    /**
     * Get all users by user type
     * 
     * @param string userType
     * 
     * @return Illuminate\Http\Request
     */

    public function getUserByType($userType)
    {
        $response=[];
        try {
            $users = User::where('usertype', $userType);
            $response["code"] = 200;
            $response["users"] = $users;
        }catch(\Exception $e){
            $response["errors"] = ["message"=>"Unable to get the users . $e"];
            $response["code"] = 400;
        }

        return response($response, $response["code"]);
    }

}
