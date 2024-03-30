<?php

namespace App\Http\Controllers\iot;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponceFormat;
use App\Models\DeviceData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class DeviceDataController extends ResponceFormat
{
    public function add_device_data(Request $r)
    {
        try {
            $rules = [
                'device_id' => 'required',
                'dc_bus_voltage' => 'required',
                'output_current' => 'required',
                'settings_freq' => 'required',
                'running_freq' => 'required',
                'rpm' => 'required',
                'run_hours' => 'required',
                // 'flow' => 'required',
            ];

            $valaditor = Validator::make($r->all(), $rules);
            if ($valaditor->fails()) {
                return $this->sendError("request validation error", $valaditor->errors(), 400);
            }

            // flow=(100*MaxRpm)/liveRPM
            // 0 to 2800 rpm
            // 0-100% flow
                // $flow=round((100*$r->rpm)/2800, 2);
                $flow=(round((100*$r->rpm)/2800, 2) >100)?100:round((100*$r->rpm)/2800, 2);


                $devicedata_to_device=[
                    "device_id" => $r->device_id,
                    "date" => date("Y-m-d"),
                    "time" => $r->run_hours,
                    "dc_bus_voltage" => $r->dc_bus_voltage,
                    "output_current" => round($r->output_current/10,2),
                    "settings_freq" => $r->settings_freq,
                    "running_freq" => $r->running_freq,
                    "rpm" => $r->rpm,
                    "flow" => $flow,
                ];
                // Log::info(print_r($devicedata_to_device, true));
            $add_device_data = DeviceData::create($devicedata_to_device);
            return $this->sendResponse($add_device_data, "add device data");
        } catch (\Throwable $th) {
            return $this->sendError("device list", $th->getMessage());
        }
    }
}
