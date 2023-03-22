<?php
namespace App\Http\Controllers\Api;

use Yajra\Datatables\Facades\Datatables;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller;
use App\Models\Access\User\User; 
use Illuminate\Support\Facades\Auth; 
use Validator;
use App\Models\Backend\referees;
use App\Models\Backend\players;
use App\Models\Backend\matches;
use Carbon\Carbon;
/**
 * Class ContactController.
 */
class ApiMatchController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */



public function getMatchDetails($id){
    $match=$id;
    $matches= matches::selectRaw('matches.aa_game as id, matches.match_day, matches.date_time, 
                                 matches.score_team_1 as score1, matches.score_team_2 as score2, 
                                 group1.omilos, group1.title  AS omilos, teams1.onoma_web AS team1, teams2.onoma_web AS team2,  
                                 referees_ref.Lastname AS ref_last_name, referees_ref.Firstname AS ref_firstname, matches.referee as ref_id, 
                                 matches.team1 as t1, matches.team2 as t2, referees_h1.Lastname AS h1_last_name, referees_h1.Firstname AS h1_firstname, 
                                 matches.helper1 as h1_id, season.period as season_name,     
                                 referees_h2.Lastname AS h2_last_name, referees_h2.Firstname AS h2_firstname, matches.helper2 as h2_id,
                                 matches.paratiritis as par_id, matches.doctor as doc_id, doctors.docLastName as doc_last, doctors.docFirstName as doc_first, 
                                 paratirites.waLastName as par_last, paratirites.waFirstName as par_first, fields.sort_name AS field, 
                                 matches.published as pub, matches.notified as notif, champs.*, fields.eps_name as arena, season.period as season')
    ->join('teams as teams1', 'teams1.team_id','=', 'matches.team1')
    ->join('teams as teams2', 'teams2.team_id','=', 'matches.team2')
    ->join('group1', 'group1.aa_group' ,'=','matches.group1')
    ->join('champs', 'champs.champ_id','=','group1.category')
    ->join('season', 'season.season_id','=', 'group1.aa_period')
    ->join('fields', 'fields.aa_gipedou','=','matches.court')
    ->join('referees as referees_ref', 'referees_ref.refaa', '=', 'matches.referee')
    ->join('referees as referees_h1', 'referees_h1.refaa', '=', 'matches.helper1')
    ->join('referees as referees_h2', 'referees_h2.refaa', '=', 'matches.helper2')  
    ->join('doctors', 'doctors.doc_id','=','matches.doctor')
    ->join('paratirites', 'paratirites.wa_id','=','matches.paratiritis')            
    ->where('matches.aa_game','=', $match)
    ->orderby('matches.date_time', 'desc')
    ->get();

    return Datatables::of($matches)
    ->addColumn('match', function($matches){
            return $matches->team1.' - '.$matches->team2;
        })
    ->addColumn('date', function($matches){
            return Carbon::parse($matches->date_time)->format('d/m/Y H:i');
        })
    ->make(true);
}

public function getTeamRoster($id){
    $team=players::selectRaw('Surname, Name, YEAR(Birthdate) as BirthYear')
                            ->where('teams_team_id','=',$id)
                            ->where('active','=',1)->get();
    return Datatables::of($team)
                            ->make(true);
}

}