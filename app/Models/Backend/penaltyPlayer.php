<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class penaltyPlayer extends Model
{
     protected $table='penalties_players';
    protected $fillable=array('id', 'player_id', 'team_id', 'match_id', 'infliction_date', 'reason', 'decision_num','fine', 'match_days', 'kind_of_days', 'remain', 'created_at', 'updated_at');
    protected $primaryKey= 'id';

    public function setUpdatedAt($value)
	{
	   //Do-nothing
	}

	public function getUpdatedAtColumn()
	{
	    //Do-nothing
	}
}