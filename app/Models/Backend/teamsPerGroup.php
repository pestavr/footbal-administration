<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class teamsPerGroup extends Model
{
     protected $table='teamspergroup';
    protected $fillable=array('id', 'group', 'team', 'points', 'weight', 'created_at','updated_at');
    protected $primaryKey= 'id';
}