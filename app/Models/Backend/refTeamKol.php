<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class refTeamKol extends Model
{
    protected $table='ref_team_kol';
    protected $fillable=array('ref', 'team', 'ref_to_team', 'reason', 'created_at', 'updated_at');
    protected $primaryKey= 'team_kol_id';

    /* return the team's court*/
   /* public function getCourt($team){
      return $this->find($team)->court;
    }

    public static function getTeamsPerGroup($id){
      return team::join('teamspergroup', 'teamspergroup.team', '=', 'teams.team_id')->where('group','=',$id)->orderBy('onoma_web')->pluck('onoma_web','team_id');
    }

    public static function getAll($id){
        return team::select('parent', 'aa_epo', 'afm', 'onoma_eps','onoma_web','onoma_SMS','region','site','address','tel','emblem','city','court','court2','code_gga','diakritika','tk','fax','etos_idrisis','email','age_level','active')->where('team_id','=',$id)->first();
    }*/
}

