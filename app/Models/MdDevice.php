<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MdDevice extends Model
{
    use HasFactory;
    protected $table = 'md_device';
    protected $primaryKey = 'device_id';
    protected $fillable = [ "imei_no","device_name"];
}
