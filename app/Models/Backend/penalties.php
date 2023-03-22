<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class penalties extends Model
{
    protected $table='penalties';
    protected $fillable=array('pen_id', 'mp_id', 'red', 'yellow', 'min', 'description', 'match_days', 'money', 'created_at', 'updated_at');
    protected $primaryKey= 'pen_id';

    
}