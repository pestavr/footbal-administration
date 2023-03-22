<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class matchPlayers extends Model
{
    protected $table='match_players';
    protected $fillable=array('mp_id', 'player_id', 'match_id', 'start_list', 'position', 'minutes', 'team_id', 'created_at', 'updated_at');
    protected $primaryKey= 'mp_id';

     public static function getMP($playerID, $matchID){
        return matchPlayers::select('mp_id')
        	   ->where('player_id','=',$playerID)
        	   ->where('match_id','=',$matchID)
        	   ->first();
    }
}