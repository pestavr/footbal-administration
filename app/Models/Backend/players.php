<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class players extends Model
{
     protected $table='players';
    protected $fillable=array('Surname', 'Name', 'F_name', 'Birthdate', 'country', 'position', 'photo','active', 'teams_team_id');
    protected $primaryKey= 'player_id';

    /*return max player_id of a team*/
    public function getMaxPlayerID($team){
      return $this->where('teams_team_id','=',$team)->orderBy('player_id', 'desc')->first()->player_id;
    }
}
