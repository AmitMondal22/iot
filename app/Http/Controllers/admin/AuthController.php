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
    function register(Request $r): JsonResponse
    {
        try {
            $rules = [
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required',
                "user_type" => "required|numeric"
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


    function add_user(Request $r): JsonResponse
    {
        try {
            $rules = [
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required',
                'origination_id' => 'required|numeric'
            ];
            $valaditor = Validator::make($r->all(), $rules);
            if ($valaditor->fails()) {
                return $this->sendError("request validation error", $valaditor->errors(), 400);
            }
            User::create([
                "name" => $r->name,
                "email" => $r->email,
                "password" => Hash::make($r->password),
                "user_type" => 1,
                "origination_id" => $r->origination_id
            ]);
            return $this->sendResponse("register", "register");
        } catch (\Throwable $th) {
            return $this->sendError("register", $th->getMessage());
        }
    }


    function edit_user(Request $r): JsonResponse
    {
        try {
            $rules = [
                'user_id' => 'required|numeric',
                'name' => 'required',
                'email' => 'required|email',
                'origination_id' => 'required|numeric',
                'password' => 'required',
            ];
            $valaditor = Validator::make($r->all(), $rules);
            if ($valaditor->fails()) {
                return $this->sendError("request validation error", $valaditor->errors(), 400);
            }
            $password = Hash::make($r->password);
            User::where("id", $r->user_id)->update([
                "name" => $r->name,
                "email" => $r->email,
                "origination_id" => $r->origination_id,
                "password" => $password
            ]);
            return $this->sendResponse("register", "register");
        } catch (\Throwable $th) {
            return $this->sendError("register", $th->getMessage());
        }
    }

    function list_user(Request $r): JsonResponse
    {
        try {
            $user = User::join("md_origination as a", 'users.origination_id', '=', 'a.origination_id')->where("users.user_type", '1')->select("users.*", "a.origination_name", "a.active_status")->get();
            return $this->sendResponse($user, "user list");
        } catch (\Throwable $th) {
            return $this->sendError("user list", $th->getMessage());
        }
    }

    function login(Request $r): JsonResponse
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
            return $this->sendResponse(["token" => $token, "user" => $user], "login");
        } catch (\Throwable $th) {
            return $this->sendError("login", $th->getMessage());
        }
    }

    function test(Request $r): JsonResponse
    {
        try {
            $data = auth()->user();
            return $this->sendResponse($data, "test");
        } catch (\Throwable $th) {
            return $this->sendError("test", $th->getMessage());
        }
    }
}
