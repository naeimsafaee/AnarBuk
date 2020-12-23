<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\oauth_access_token;
use Illuminate\Support\Str;


class loginCotroller extends Controller
{

    public function firstRun(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'device_id' => 'string|required|unique:users,DeviceID',
                'model' => 'string|required',
            ],
            [
                "device_id.required" => "device_id is required",
                "device_id.unique" => "device_id must be unique",
                "model.required" => "model is required"
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                [
                    "responseCode" => 401,
                    "errorCode" => 'incomplete data',
                    'message' => $validator->errors(),

                ], 401);
        }

        $token = Str::random(60);

        $user = User::create([
            'DeviceID' => $request->device_id,
            'Model' => $request->model,
            'api_token' => $token,
        ]);

//        oauth_access_token::where('user_id', $user->id)->delete();
//        $token = $user->createToken('Register')->accessToken;

        $user->api_token = $token;
        $user->save();

        Auth::login($user);
        return response()->json(["token" => $token , "Check" => Auth::check()], 200);
    }

    public function login(Request $request)
    {
        return response()->json("LoggedIn", 200);
    }
}
