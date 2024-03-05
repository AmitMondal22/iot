<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MdOrigination extends Model
{
    use HasFactory;
    protected $table = 'md_origination';
    protected $primaryKey = 'origination_id';
    protected $fillable = ["origination_name", "active_status", "create_by"];


    public function assign_devices()
    {
        return $this->hasMany(TdAssignDevice::class, 'origination_id', 'origination_id')
            ->join("users as a","a.id","=","td_assign_device.assign_user_id")
            ->select('td_assign_device.*', 'users.*')
            ->get();
    }
}
