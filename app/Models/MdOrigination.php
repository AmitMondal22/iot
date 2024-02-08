<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MdOrigination extends Model
{
    use HasFactory;
    protected $table = 'md_origination';
    protected $primaryKey = 'origination_id';
    protected $fillable = [ "origination_name","active_status","create_by"];
}
