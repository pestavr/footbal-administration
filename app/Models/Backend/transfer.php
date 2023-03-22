<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class transfer extends Model
{
    protected $table='transfers';
    protected $fillable=array('met_id', 'player_id', 'team_id_from', 'team_id_to', 'date', 'timestamp', 'created_at', 'updated_at');
    protected $primaryKey= 'met_id';
}
