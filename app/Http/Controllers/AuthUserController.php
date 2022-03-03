<?php

namespace App\Http\Controllers;

use App\Models\AuthUser;
use Illuminate\Http\Request;
use App\Http\Requests\StoreAuthUserRequest;
use App\Http\Requests\UpdateAuthUserRequest;

class AuthUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    //register freelancer / admin
    public function create(Request $request) 
    {
        if(AuthUser::where('user_skypeid',$request->user_skypeid)->exists())
            return response()->json([
                "message" => "the user already exists!"
            ],400);
        $authuser = new AuthUser;
        $authuser->user_skypeid = $request->user_skypeid;
        $authuser->access = "false";

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 10; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        $authuser->password = $randomString;
        $authuser->user_id = "";
        $authuser->save();

        return response()->json([
            "message" => "Register success"
        ], 201);
    }


    // Freelancer / admin login part

    public function login(Request $request)
    {
        if(AuthUser::where('password', $request->user_id)->exists()) {
            $authuser = AuthUser::where('password', $request->user_id)->get()->toJson(JSON_PRETTY_PRINT);
            $authuser = json_decode($authuser);
            if($authuser[0]->access != "true") {
                return response()->json([
                    "message" => "Your account is inactive"
                ],401);
            }
            response()->json([
                "id" => $authuser->user_id
            ]);
        }
        else {
            return response()->json([
                "message" => "User Not found"
            ], 404);
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAuthUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAuthUserRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AuthUser  $authUser
     * @return \Illuminate\Http\Response
     */
    public function show(AuthUser $authUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AuthUser  $authUser
     * @return \Illuminate\Http\Response
     */
    public function edit(AuthUser $authUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAuthUserRequest  $request
     * @param  \App\Models\AuthUser  $authUser
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAuthUserRequest $request, AuthUser $authUser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AuthUser  $authUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(AuthUser $authUser)
    {
        //
    }
}
