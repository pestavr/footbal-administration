<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class team extends Model
{
    protected $table='teams';
    protected $fillable=array('parent',
  'aa_epo',
  'afm',
  'onoma_eps',
  'onoma_web',
  'onoma_SMS',
  'region',
  'site',
  'address',
  'tel',
  'emblem',
  'city',
  'court',
  'court2',
  'code_gga',
  'diakritika',
  'tk',
  'fax',
  'etos_idrisis',
  'email',
  'age_level',
  'active', 
  'updated_at',
  'created_at');
    protected $primaryKey= 'team_id';

    /* return the team's court*/
    public function getCourt($team){
      return $this->find($team)->court;
    }

    public static function getTeamsPerGroup($id){
      return team::join('teamspergroup', 'teamspergroup.team', '=', 'teams.team_id')->where('group','=',$id)->orderBy('onoma_web')->pluck('onoma_web','team_id');
    }

    public static function getAll($id){
        return team::select('parent', 'aa_epo', 'afm', 'onoma_eps','onoma_web','onoma_SMS','region','site','address','tel','emblem','city','court','court2','code_gga','diakritika','tk','fax','etos_idrisis','email','age_level','active')->where('team_id','=',$id)->first();
    }
    public static function getIDfromEPO($team){
      if (team::select('team_id')->where('aa_epo','=', $team)->exists())
        $res=team::select('team_id')->where('aa_epo','=', $team)->first();
      else
        $res=config('default.team');
      return $res;
    }
}

