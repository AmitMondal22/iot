<?php

namespace App\Http\Controllers\iot;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponceFormat;
use App\Models\MdDevice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DeviceController extends ResponceFormat
{
    public function add_device(Request $r)
    {
        try {
            $rules = [
                'device_name' => 'required',
                "imei_no" => 'required',
            ];

            $valaditor = Validator::make($r->all(), $rules);
            if ($valaditor->fails()) {
                return $this->sendError("request validation error", $valaditor->errors(), 400);
            }



            $find_device = MdDevice::where("imei_no", $r->imei_no)->first();
            if (!empty($find_device)) {
                $device_name = MdDevice::latest()->first();
                return $this->sendError("device already exist",["u_id"=>$find_device->device_name]);
            }

            $device_name = MdDevice::latest()->first();
            if(!empty($device_name->device_name)){
                $u_id = $this->decrementString($device_name->device_name);
            }else{
                // $u_id =$r->device_name;
                $u_id ="TS00000001";

            }

            MdDevice::create([
                "imei_no"=>$r->imei_no,
                "device_name" => $u_id
            ]);


            return $this->sendResponse(["u_id"=>$u_id], "device list");
        } catch (\Throwable $th) {
            return $this->sendError("device list", $th->getMessage());
        }
    }



    function decrementString($str) {
        // Extract non-numeric part
        $nonNumericPart = preg_replace('/[0-9]+/', '', $str);

        // Extract numeric part
        preg_match('/[0-9]+$/', $str, $matches);
        $numericPart = isset($matches[0]) ? $matches[0] : '';

        $newNumericPart = ($numericPart === '') ? 0 : intval($numericPart) + 1;

        if ($newNumericPart < 0) {
            $newNumericPart = 0;
        }

        // Pad the numeric part with leading zeros to maintain the same length
        $paddedNumericPart = str_pad($newNumericPart, strlen($numericPart), '0', STR_PAD_LEFT);
        return $nonNumericPart . $paddedNumericPart;
    }

    public function checked_device(Request $r)
    {
        try {

            $rules = [
                'device_name' => 'required',
            ];

            $valaditor = Validator::make($r->all(), $rules);
            if ($valaditor->fails()) {
                return $this->sendError("request validation error", $valaditor->errors(), 400);
            }



            $find_device = MdDevice::where("device_name", $r->device_name)->first();
            if (!empty($find_device)) {
                return $this->sendResponse($find_device, "device is already exists");
            }
            return $this->sendResponse('', "device not found");
        } catch (\Throwable $th) {
            return $this->sendError("device list", $th->getMessage());
        }
    }
}
