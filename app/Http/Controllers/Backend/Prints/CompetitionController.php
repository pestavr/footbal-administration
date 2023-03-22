<?php

namespace App\Http\Controllers\Backend\Prints;

use Redirect;
use DB;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Controllers\Controller;
use App\Models\Backend\players;
use App\Models\Backend\matches;
use App\Models\Backend\team;
use App\Models\Backend\season;
use App\Models\Backend\matchPlayers;
use App\Models\Backend\teamsPerGroup;
use Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;

class CompetitionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return view('backend.prints.competition.index');
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ranking(){
        return view('backend.prints.competition.ranking');
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function sym(){
        return view('backend.prints.competition.sym');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function scorer(){
        return view('backend.prints.competition.scorer');
    }
 //Omades ana Omilo 
    public function getTeams(){

        $category= request('category');
        
        session()->put('category', $category);

        $teams= team::selectRaw('teams.team_id as id, teams.onoma_web as name, teams.tel as tel, teams.email as email, teamsAccountable.Name as aName, teamsAccountable.Surname as aSurname')
                ->leftJoin('teamsAccountable', 'teams.team_id','=', 'teamsAccountable.team_id')
                ->join('teamspergroup', 'teams.team_id' ,'=','teamspergroup.team')
                ->where('teamspergroup.group','=', $category)
                ->orderby('teams.onoma_web', 'asc')
                ->get();
        $response= Datatables::of($teams)
        ->addIndexColumn()
        ->addColumn('teamsAccountable', function($teams){
                return $teams->aSurname.' '.$teams->aName;
            });
        
        $response=$response->make(true);
        return $response;
    }

 //Vathmologia ana Omilo 
    public function getRanking(){

        $category= request('category');
        
        session()->put('category', $category);

        $ranking=teamsPerGroup::selectRaw('teamspergroup.*, teams.onoma_web as onoma, teams.emblem as emblem, IFNULL(points,0)- IFNULL(poines,0) as points_syn')
                                ->join('teams','teams.team_id','=','teamspergroup.team')
                                ->where('group','=', $category)
                                ->orderBy('points_syn', 'desc')
                                ->orderBy('weight', 'asc')
                                ->orderBy('onoma', 'asc');
        return Datatables::of($ranking)
        ->addIndexColumn()
        ->addColumn('syn_vathm', function($ranking){
                return intval($ranking->points)-intval($ranking->poines);
            })
        ->addColumn('syn_match', function($ranking){
                return intval($ranking->match_home)+intval($ranking->match_away);
            })
       ->addColumn('goal_difference', function($ranking){
                return (intval($ranking->goalHomePlus)+intval($ranking->goalAwayPlus))-(intval($ranking->goalHomeMinus)+intval($ranking->goalAwayMinus));
            })
        ->make(true);
    }

 //Symmetoxh ana Omilo 
    public function getSym(){

        $category= request('category');
        
        session()->put('category', $category);

        $sym= matchPlayers::selectRaw('SUM( match_players.minutes ) AS sym, players.Surname AS surname, players.name AS name, match_players.player_id as pid, teams.onoma_web AS team')
                ->join('players', 'players.player_id', '=', 'match_players.player_id')
                ->join('teams', 'match_players.team_id', '=' ,'teams.team_id')
                ->join('matches', function($join)use($category){
                        $join->on('matches.aa_game','=','match_players.match_id')
                             ->where('matches.group1','=', $category);
                })
                ->join('group1',  'group1.aa_group', '=', 'matches.group1')
                ->join('season', function($join){
                        $join->on('season.season_id','=','group1.aa_period')
                             ->where('season.season_id','=',session('season'));
                })
                ->groupBy('players.player_id')     
                ->orderby('sym', 'desc')
                ->get();
        $response= Datatables::of($sym)
        ->addIndexColumn()
        ->addColumn('playerName', function($sym){
                return $sym->surname.' '.$sym->name;
            });
        
        $response=$response->make(true);
        return $response;
    }


 //Scorer ana Omilo 
    public function getScorer(){

        $category= request('category');
        
        session()->put('category', $category);

        $sym= matchPlayers::selectRaw('COUNT( goal.min ) AS goal, players.Surname AS surname, players.name AS name, match_players.player_id as pid, teams.onoma_web AS team')
                ->join('goal', function($join){
                        $join->on('goal.mp_id', '=', 'match_players.mp_id')
                             ->where('goal.own_goal','=', 0);
                })
                ->join('players', 'players.player_id', '=', 'match_players.player_id')
                ->join('teams', 'match_players.team_id', '=' ,'teams.team_id')
                ->join('matches', function($join)use($category){
                        $join->on('matches.aa_game','=','match_players.match_id')
                             ->where('matches.group1','=', $category);
                })
                ->join('group1',  'group1.aa_group', '=', 'matches.group1')
                ->join('season', function($join){
                        $join->on('season.season_id','=','group1.aa_period')
                             ->where('season.season_id','=',session('season'));
                })
                ->groupBy('players.player_id')     
                ->orderby('goal', 'desc')
                ->get();
        $response= Datatables::of($sym)
        ->addIndexColumn()
        ->addColumn('playerName', function($sym){
                return $sym->surname.' '.$sym->name;
            });
        
        $response=$response->make(true);
        return $response;
    }



   

}
