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

            $device_data_list = DeviceData::where("device_id",$r->device_id)->whereBetween("date",[$fdate,$tdate])->orderBy("data_id","DESC")->get();
            return $this->sendResponse($device_data_list, "device data list");
        } catch (\Throwable $th) {
            return $this->sendError("device data list", $th->getMessage());
        }
    }

    public function device_data_list_user(Request $r){
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

            $device_data_list = DeviceData::join("td_assign_device as a","md_device.device_id","=","a.device_id")->where("a.origination_id",auth()->user()->origination_id)->where("md_device.device_id",$r->device_id)->where("a.assign_user_id",auth()->user()->id)->whereBetween("md_device.date",[$fdate,$tdate])->orderBy("md_device.data_id","DESC")->select('md_device.*')->get();
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

            $device_data_list = DeviceData::where("device_id",$r->device_id)->orderBy("data_id","desc")->first();
            // $chart=DeviceData::where("device_id",$r->device_id)->orderBy("device_id","desc")->orderBy("data_id", "desc")
            $chart=DeviceData::where("device_id",$r->device_id)->orderBy("data_id", "desc")
            ->take(5)->get();
            $data=[
                "device_data_list"=>$device_data_list,
                "chart_data_list"=>$chart
            ];
            return $this->sendResponse($data, "last device data");
        } catch (\Throwable $th) {
            return $this->sendError("last device data", $th->getMessage());
        }
    }



    public function last_device_data_user(Request $r){
        try {
            $rules = [
                'device_id' => 'required',
            ];

            $valaditor = Validator::make($r->all(), $rules);
            if ($valaditor->fails()) {
                return $this->sendError("request validation error", $valaditor->errors(), 400);
            }

            $device_data_list = DeviceData::select('td_device_data.*')
            ->join('md_device AS b', 'b.device_name', '=', 'td_device_data.device_id')
            ->join('td_assign_device AS a', 'b.device_id', '=', 'a.device_id')
            ->where('a.origination_id', auth()->user()->origination_id)
            ->where('td_device_data.device_id', $r->device_id)
            ->where("a.assign_user_id",auth()->user()->id)
            ->orderBy('td_device_data.data_id', 'DESC')->first();
            // $chart=DeviceData::where("device_id",$r->device_id)->orderBy("device_id","desc")->orderBy("data_id", "desc")

//             "select td_device_data.*
// from td_device_data
// inner join md_device as b on td_device_data.device_name = a.device_id
// inner join td_assign_device as a on a.device_id = b.device_id
// where a.origination_id = 2
// and td_device_data.device_id = 'ABCDE01001'
// order by td_device_data.data_id desc limit 1"




            $chart=DeviceData::select('td_device_data.*')
            ->join('md_device AS b', 'b.device_name', '=', 'td_device_data.device_id')
            ->join('td_assign_device AS a', 'b.device_id', '=', 'a.device_id')
            ->where('a.origination_id', auth()->user()->origination_id)
            ->where('td_device_data.device_id', $r->device_id)
            ->where("a.assign_user_id",auth()->user()->id)
            ->orderBy('td_device_data.data_id', 'DESC')
            ->take(5)->get();
            $data=[
                "device_data_list"=>$device_data_list,
                "chart_data_list"=>$chart
            ];
            return $this->sendResponse($data, "last device data");
        } catch (\Throwable $th) {
            return $this->sendError("last device data", $th->getMessage());
        }
    }
}
