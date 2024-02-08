<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TdAssignUser extends Model
{
    use HasFactory;

    protected $table = 'td_assign_user';
    protected $primaryKey = 'assign_user_id';
    protected $fillable = [  "assign_device_id", "user_id", "create_by"];
}
