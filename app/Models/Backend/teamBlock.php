<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class teamBlock extends Model
{
     protected $table='ref_team_kol';
    protected $fillable=array('ref', 'team', 'ref_to_team', 'reason', 'created_at', 'updated_at');
    protected $primaryKey= 'team_kol_id';
}
