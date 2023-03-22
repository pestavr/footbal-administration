<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class matches extends Model
{
    protected $table='matches';
    protected $fillable=array('postponed', 'group1', 'round', 'match_day', 'date_time', 'court', 'publ','team1', 'team2', 'score_team_1', 'score_team_2', 'referee', 'helper1', 'helper2', 'ref_grades', 'h1_grades', 'h2_grades','points1', 'points2', 'post', 'duration', 'stats', 'published', 'notified', 'paratiritis', 'doctor', 'ref_paratiritis', 'publ_doc', 'publ_ref_obs', 'publ_wa', 'poines', 'locked','created_at', 'updated_at');
    protected $primaryKey= 'aa_game';


    public static function getAll($id){
        return matches::select('postponed', 'group1', 'round', 'match_day', 'date_time', 'court', 'publ','team1', 'team2', 'score_team_1', 'score_team_2', 'referee', 'helper1', 'helper2', 'ref_grades', 'h1_grades', 'h2_grades','points1', 'points2', 'post', 'duration', 'stats', 'published', 'notified', 'paratiritis', 'doctor', 'ref_paratiritis', 'publ_doc', 'publ_ref_obs', 'publ_wa', 'poines', 'locked')->where('aa_game','=',$id)->first();
    }
}
