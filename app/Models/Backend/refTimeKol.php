<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class refTimeKol extends Model
{
    protected $table='ref_time_kol';
    protected $fillable=array('ref', 'kind', 'data' ,'created_at', 'updated_at');
    protected $primaryKey= 'time_kol_id';


}
