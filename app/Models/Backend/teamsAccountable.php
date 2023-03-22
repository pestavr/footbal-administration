<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class teamsAccountable extends Model
{
    protected $table='teamsAccountable';
    protected $fillable=array('id', 'team_id', 'Name', 'Surname', 'FName', 'Address', 'Tk','Region', 'City','Nomos','Perifereia','Tel', 'Mobile', 'email', 'active','created_at', 'updated_at');
    protected $primaryKey= 'id';
}