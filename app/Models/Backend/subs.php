<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class subs extends Model
{
    protected $table='subs';
    protected $fillable=array('sub_id', 'mp_id_out', 'mp_id_in', 'min', 'created_at', 'updated_at');
    protected $primaryKey= 'sub_id';

    
}