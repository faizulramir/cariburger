<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stall extends Model
{
    protected $table = 'stalls';
    protected $fillable = ['name', 'state', 'district', 'operation_time', 'operation_day', 'landmark', 'waze_url', 'creator_name'];

}
