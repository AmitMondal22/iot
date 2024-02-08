<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponceFormat;
use App\Models\MdOrigination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OriginationController extends ResponceFormat
{
    function add_origination(Request $r){
        try {
            $rules = [
                'origination_name' => 'required'
            ];
            $valaditor = Validator::make($r->all(), $rules);
            if ($valaditor->fails()) {
                return $this->sendError("request validation error", $valaditor->errors(), 400);
            }
            $origination = MdOrigination::create([
                "origination_name"=>$r->origination_name,
                "active_status"=>"A",
                "create_by"=>auth()->user()->id
            ]);
            return $this->sendResponse($origination, "origination added");
        } catch (\Throwable $th) {
            return $this->sendError("device data list", $th->getMessage());
        }
    }
}
