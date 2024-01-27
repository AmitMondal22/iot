<?php

namespace App\Http\Controllers\iot;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponceFormat;
use App\Models\MdDevice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DeviceController extends ResponceFormat
{
    public function add_device(Request $r){
        try {
            $rules = [
                'device_name' => 'required',
            ];

            $valaditor = Validator::make($r->all(), $rules);
            if ($valaditor->fails()) {
                return $this->sendError("request validation error", $valaditor->errors(), 400);
            }

            $find_device = MdDevice::where("device_name",$r->device_name)->first();
            if(!empty($find_device)){
                return $this->sendError("device already exist");
            }
            $device_list = MdDevice::create(["device_name"=>$r->device_name]);
            return $this->sendResponse($device_list, "device list");
        } catch (\Throwable $th) {
            return $this->sendError("device list", $th->getMessage());
        }
    }

    public function checked_device(Request $r){
        try {

            $rules = [
                'device_name' => 'required',
            ];

            $valaditor = Validator::make($r->all(), $rules);
            if ($valaditor->fails()) {
                return $this->sendError("request validation error", $valaditor->errors(), 400);
            }


            $find_device = MdDevice::where("device_name",$r->device_name)->first();
            if(!empty($find_device)){
                return $this->sendResponse($find_device, "device is already exists");
            }
            return $this->sendResponse('', "device not found");
        } catch (\Throwable $th) {
            return $this->sendError("device list", $th->getMessage());
        }
    }
}
