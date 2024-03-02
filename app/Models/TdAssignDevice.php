<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TdAssignDevice extends Model
{
    use HasFactory;

    protected $table = 'td_assign_device';
    protected $primaryKey = 'assign_device_id';
    protected $fillable = [  "device_id", "origination_id","assign_user_id", "create_by"];



    public function device()
    {
        return $this->belongsTo(MdDevice::class, 'device_id', 'device_id')->orderBy('device_name');
    }
}
