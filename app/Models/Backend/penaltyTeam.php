<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class penaltyTeam extends Model
{
     protected $table='penalties_teams';
    protected $fillable=array('id', 'team_id',  'match_id', 'infliction_date', 'reason', 'decision_num','fine', 'match_days', 'pointsoff', 'description', 'efesi', 'remain', 'created_at', 'updated_at');
    protected $primaryKey= 'id';
}