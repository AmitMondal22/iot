<?php

namespace App\Http\Controllers\iot;

use App\Http\Controllers\Controller;
use App\Models\DeviceData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DeviceDataController extends Controller
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
                'flow' => 'required',
            ];

            $valaditor = Validator::make($r->all(), $rules);
            if ($valaditor->fails()) {
                return $this->sendError("request validation error", $valaditor->errors(), 400);
            }


            $add_device_data = DeviceData::create([
                "device_id" => $r->device_id,
                "date" => date("Y-m-d"),
                "time" => date("H:i:s"),
                "dc_bus_voltage" => $r->dc_bus_voltage,
                "output_current" => $r->output_current,
                "settings_freq" => $r->settings_freq,
                "running_freq" => $r->running_freq,
                "rpm" => $r->rpm,
                "flow" => $r->flow,
            ]);
            return $this->sendResponse($add_device_data, "add device data");
        } catch (\Throwable $th) {
            return $this->sendError("device list", $th->getMessage());
        }
    }
}
