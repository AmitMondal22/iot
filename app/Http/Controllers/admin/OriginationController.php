<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponceFormat;
use App\Models\MdOrigination;
use App\Models\TdAssignDevice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OriginationController extends ResponceFormat
{
    function add_origination(Request $r)
    {
        try {
            $rules = [
                'origination_name' => 'required'
            ];
            $valaditor = Validator::make($r->all(), $rules);
            if ($valaditor->fails()) {
                return $this->sendError("request validation error", $valaditor->errors(), 400);
            }
            $origination = MdOrigination::create([
                "origination_name" => $r->origination_name,
                "active_status" => "A",
                "create_by" => auth()->user()->id
            ]);
            return $this->sendResponse($origination, "origination added");
        } catch (\Throwable $th) {
            return $this->sendError("device data list", $th->getMessage());
        }
    }

    function edit_origination(Request $r)
    {
        try {
            $rules = [
                'origination_id' => 'required',
                'origination_name' => 'required'
            ];
            $valaditor = Validator::make($r->all(), $rules);
            if ($valaditor->fails()) {
                return $this->sendError("request validation error", $valaditor->errors(), 400);
            }
            $origination = MdOrigination::where("origination_id", $r->origination_id)->update([
                "origination_name" => $r->origination_name,
                "create_by" => auth()->user()->id
            ]);
            return $this->sendResponse($origination, "origination updated");
        } catch (\Throwable $th) {
            return $this->sendError("device data list", $th->getMessage());
        }
    }

    function delete_origination(Request $r)
    {
        try {
            $rules = [
                'origination_id' => 'required'
            ];
            $valaditor = Validator::make($r->all(), $rules);
            if ($valaditor->fails()) {
                return $this->sendError("request validation error", $valaditor->errors(), 400);
            }
            $origination = MdOrigination::where("origination_id", $r->origination_id)->delete();
            return $this->sendResponse($origination, "origination deleted");
        } catch (\Throwable $th) {
            return $this->sendError("device data list", $th->getMessage());
        }
    }


    function list_origination(Request $r)
    {
        try {
            $origination = MdOrigination::get();
            return $this->sendResponse($origination, "origination list");
        } catch (\Throwable $th) {
            return $this->sendError("device data list", $th->getMessage());
        }
    }

    function assign_origination(Request $r)
    {
        try {
            $rules = [
                'origination_id' => 'required',
                'device_id' => 'required'
            ];
            $valaditor = Validator::make($r->all(), $rules);
            if ($valaditor->fails()) {
                return $this->sendError("request validation error", $valaditor->errors(), 400);
            }

            $origination = TdAssignDevice::create([
                "device_id" => $r->device_id,
                "origination_id" => $r->origination_id,
                "create_by" => auth()->user()->id
            ]);
            return $this->sendResponse($origination, "origination assigned");
        } catch (\Throwable $th) {
            return $this->sendError("device data list", $th->getMessage());
        }
    }

    function assign_multiple_origination(Request $r)
    {
        try {
            $rules = [
                'organization_id' => 'required',
                'all_device' => 'required'
            ];
            $valaditor = Validator::make($r->all(), $rules);
            if ($valaditor->fails()) {
                return $this->sendError("request validation error", $valaditor->errors(), 400);
            }
            $successCount = 0;
            $errors = [];
            foreach ($r->all_device as $device) {
                try {
                    $origination = TdAssignDevice::create([
                        "device_id" => $device['device_id'],
                        "origination_id" => $r->organization_id,
                        "create_by" => auth()->user()->id
                    ]);
                    $successCount++;
                } catch (\Exception $e) {
                    $errors[] = $e->getMessage();
                }
            }
            if ($successCount == count($r->all_device)) {
                return $this->sendResponse($origination, "All originations assigned successfully");
            } else {
                return $this->sendError("Some originations could not be assigned", $errors);
            }
        } catch (\Throwable $th) {
            return $this->sendError("device data list", $th->getMessage());
        }
    }

    function edit_assign_origination(Request $r)
    {
        try {
            $rules = [
                'assign_device_id' => 'required',
                'origination_id' => 'required',
                'device_id' => 'required'
            ];
            $valaditor = Validator::make($r->all(), $rules);
            if ($valaditor->fails()) {
                return $this->sendError("request validation error", $valaditor->errors(), 400);
            }

            $origination = TdAssignDevice::where("assign_device_id", $r->assign_device_id)->update([
                "device_id" => $r->device_id,
                "origination_id" => $r->origination_id,
                "create_by" => auth()->user()->id
            ]);
            return $this->sendResponse($origination, "origination updated");
        } catch (\Throwable $th) {
            return $this->sendError("device data list", $th->getMessage());
        }
    }


    function list_assign_origination(Request $r)
    {
        try {
            $origination = TdAssignDevice::join("md_device as a", 'td_assign_device.device_id', '=', 'a.device_id')->join("md_origination as b", 'td_assign_device.origination_id', '=', 'b.origination_id')->select("td_assign_device.*", "a.device_name", "b.origination_name")->get();
            return $this->sendResponse($origination, "origination list");
        } catch (\Throwable $th) {
            return $this->sendError("device data list", $th->getMessage());
        }
    }



    function list_origination_to_device(Request $r)
    {

        try {
            // $origination = MdOrigination::get();
            // $assignDevices =  $origination->assign_devices()->with('device')->get();

            $originations = MdOrigination::with('assign_devices.device')->get();
            return $this->sendResponse($originations, "origination list");
            // return $this->sendResponse($assignDevices, "origination list");
        } catch (\Throwable $th) {
            return $this->sendError("device data list", $th->getMessage());
        }
    }
}
