<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class anaptixi extends Model
{
    protected $table='anaptixi';
    protected $fillable=array('n_of_teams', 'round', 'match_days', 'home', 'away');
    protected $primaryKey= 'an_id';
}