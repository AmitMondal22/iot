<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponceFormat;
use App\Models\DeviceData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DeviceDataController extends ResponceFormat
{
    public function device_data_list(Request $r){
        try {
            $rules = [
                'start_date_time' => 'required',
                'end_date_time' => 'required',
                'device_id' => 'required',
            ];

            $valaditor = Validator::make($r->all(), $rules);
            if ($valaditor->fails()) {
                return $this->sendError("request validation error", $valaditor->errors(), 400);
            }

            $fdate=$r->start_date_time;
            $tdate=$r->end_date_time;

            $device_data_list = DeviceData::where("device_id",$r->device_id)->whereBetween("date",[$fdate,$tdate])->get();
            return $this->sendResponse($device_data_list, "device data list");
        } catch (\Throwable $th) {
            return $this->sendError("device data list", $th->getMessage());
        }
    }

    public function last_device_data(Request $r){
        try {
            $rules = [
                'device_id' => 'required',
            ];

            $valaditor = Validator::make($r->all(), $rules);
            if ($valaditor->fails()) {
                return $this->sendError("request validation error", $valaditor->errors(), 400);
            }

            $device_data_list = DeviceData::where("device_id",$r->device_id)->orderBy("id","desc")->first();
            return $this->sendResponse($device_data_list, "last device data");
        } catch (\Throwable $th) {
            return $this->sendError("last device data", $th->getMessage());
        }
    }
}
