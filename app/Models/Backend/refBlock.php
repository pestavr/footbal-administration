<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class refBlock extends Model
{
     protected $table='ref_time_kol';
    protected $fillable=array('ref', 'date_time_from', 'date_time_to', 'created_at', 'updated_at');
    protected $primaryKey= 'time_kol_id';
}
