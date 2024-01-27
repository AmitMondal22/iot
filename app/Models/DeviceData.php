<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceData extends Model
{
    use HasFactory;

    protected $table = 'td_device_data';
    protected $primaryKey = 'data_id';
    protected $fillable = [ "device_id", "date", "time", "dc_bus_voltage", "output_current", "settings_freq", "running_freq", "rpm", "flow"];
}
