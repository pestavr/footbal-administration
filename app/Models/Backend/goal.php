<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class goal extends Model
{
    protected $table='goal';
    protected $fillable=array('goal_id', 'mp_id', 'min', 'own_goal', 'penalty', 'created_at', 'updated_at');
    protected $primaryKey= 'goal_id';

    
}