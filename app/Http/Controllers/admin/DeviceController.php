<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponceFormat;
use App\Models\MdDevice;
use Illuminate\Http\Request;

class DeviceController extends ResponceFormat
{
    public function device_list(){
        try {
            $device_list = MdDevice::all();
            return $this->sendResponse($device_list, "device list");
        } catch (\Throwable $th) {
            return $this->sendError("device list", $th->getMessage());
        }
    }


    public function device_list_user(){
        try {
            $device_list = MdDevice::join("td_assign_device as a","md_device.device_id","=","a.device_id")->where("a.origination_id",auth()->user()->origination_id)->get();
            return $this->sendResponse($device_list, "device list");
        } catch (\Throwable $th) {
            return $this->sendError("device list", $th->getMessage());
        }
    }
}
