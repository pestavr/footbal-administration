<?php
namespace App\Http\Controllers\Api;

use Yajra\Datatables\Facades\Datatables;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller;
use App\Models\Access\User\User; 
use Illuminate\Support\Facades\Auth; 
use Validator;
use App\Models\Backend\referees;
use App\Models\Backend\matches;
use Carbon\Carbon;
/**
 * Class ContactController.
 */
class ApiProgramController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */


    public function getMatches(){ 
            $user=Auth::user()->id;
            $time=request('time');
            //$symbol= ($time==1)?'<':'>=';
            $symbol= '>=';
            $referees= Referees::selectRaw('refaa as id')
                                ->join('users', 'users.mobile','=','referees.tel')
                                ->where('users.id','=',$user)
                                ->get();
            foreach($referees as $referee)
                $id= $referee->id;
            $matches= matches::selectRaw('matches.aa_game as id, matches.postponed as anavlithike, team1.onoma_web as ghpedouxos, team2.onoma_web as filoxenoumenos, fields.eps_name as arena, group1.title as katigoriaFullName, 
                                          group1.category as kathgoria, group1.locked as groupLocked, matches.score_team_1 as score1, 
                                          matches.score_team_2 as score2, matches.date_time as date_time, matches.published as published')
                ->join('teams as team1', 'team1.team_id','=', 'matches.team1')
                ->join('teams as team2', 'team2.team_id','=', 'matches.team2')
                ->join('group1', 'group1.aa_group' ,'=','matches.group1')
                ->join('season', 'season.season_id','=', 'group1.aa_period')
                ->join('fields', 'fields.aa_gipedou','=','matches.court')
                ->where('season.running','=',1)
                ->where('matches.published','=', '0')
                ->where('matches.date_time','<>',config('default.datetime'))
                ->where('matches.date_time',$symbol,Carbon::now()->format('Y/m/d H:i:s'))
                ->where(function($query) use ($id){
                    $query->where('matches.referee','=', $id)
                          ->orWhere('matches.helper1','=', $id)
                          ->orWhere('matches.helper2','=', $id);
                })
                ->orderby('matches.date_time', 'desc')
                ->get();
        return Datatables::of($matches)

        ->addColumn('match', function($matches){
                return $matches->ghp.' - '.$matches->fil;
            })
        ->addColumn('date', function($matches){
                return Carbon::parse($matches->date_time)->format('d/m/Y H:i');
            })
        ->rawColumns(['actions'])
        ->make(true);
        
    }

    
    public function getAllMatches(){ 
        $user=Auth::user()->id;
        $referees= Referees::selectRaw('refaa as id')
                            ->join('users', 'users.mobile','=','referees.tel')
                            ->where('users.id','=',$user)
                            ->get();
        foreach($referees as $referee)
            $id= $referee->id;
        $matches= matches::selectRaw('matches.aa_game as id, matches.postponed as anavlithike, team1.onoma_web as ghpedouxos, 
                                      team2.onoma_web as filoxenoumenos, fields.eps_name as arena, group1.title as katigoriaFullName, 
                                      group1.category as kathgoria, group1.locked as groupLocked, matches.score_team_1 as score1, 
                                      matches.score_team_2 as score2, matches.date_time as date_time, matches.published as published')
            ->join('teams as team1', 'team1.team_id','=', 'matches.team1')
            ->join('teams as team2', 'team2.team_id','=', 'matches.team2')
            ->join('group1', 'group1.aa_group' ,'=','matches.group1')
            ->join('season', 'season.season_id','=', 'group1.aa_period')
            ->join('fields', 'fields.aa_gipedou','=','matches.court')
            ->where('season.running','=',1)
            ->where('matches.published','=', '0')
            ->where('matches.date_time','<>',config('default.datetime'))
            ->where(function($query) use ($id){
                $query->where('matches.referee','=', $id)
                      ->orWhere('matches.helper1','=', $id)
                      ->orWhere('matches.helper2','=', $id);
            })
            ->orderby('matches.date_time', 'desc')
            ->get();
    return Datatables::of($matches)

    ->addColumn('match', function($matches){
            return $matches->ghpedouxos.' - '.$matches->filoxenoumenos;
        })
    ->addColumn('date', function($matches){
            return Carbon::parse($matches->date_time)->format('d/m/Y H:i');
        })
    ->make(true);
    
}



}
