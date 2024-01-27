<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\ResponceFormat;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends ResponceFormat
{
    function register(Request $r):JsonResponse
    {
        try {
            $rules = [
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required',
                "user_type"=>"required|numeric"
            ];
            $valaditor = Validator::make($r->all(), $rules);
            if ($valaditor->fails()) {
                return $this->sendError("request validation error", $valaditor->errors(), 400);
            }
            User::create([
                "name" => $r->name,
                "email" => $r->email,
                "password" => Hash::make($r->password),
                "user_type" => $r->user_type
            ]);
            return $this->sendResponse("register", "register");
        } catch (\Throwable $th) {
            return $this->sendError("register", $th->getMessage());
        }
    }

    function login(Request $r):JsonResponse
    {
        try {
            $rules = [
                'email' => 'required|email',
                'password' => 'required',
            ];
            $valaditor = Validator::make($r->all(), $rules);
            if ($valaditor->fails()) {
                return $this->sendError("request validation error", $valaditor->errors(), 400);
            }
            $user = User::where("email", $r->email)->first();
            if (!$user) {
                return $this->sendError("user not found");
            }
            if (!Hash::check($r->password, $user->password)) {
                return $this->sendError("password not match");
            }
            $token = $user->createToken($user->name, [$user->user_type])->plainTextToken;
            return $this->sendResponse(["token" => $token,"user"=>$user], "login");
        } catch (\Throwable $th) {
            return $this->sendError("login", $th->getMessage());
        }
    }

    function test(Request $r):JsonResponse
    {
        try {
            $data=auth()->user();
            return $this->sendResponse($data, "test");
        } catch (\Throwable $th) {
            return $this->sendError("test", $th->getMessage());
        }
    }
}
