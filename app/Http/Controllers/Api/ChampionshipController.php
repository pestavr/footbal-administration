<?php

namespace App\Http\Controllers\Api;

use Redirect;
use DB;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Controllers\Controller;
use App\Models\Backend\groups;
use App\Models\Backend\matches;
use App\Models\Backend\season;
use App\Models\Backend\champs;
use App\Models\Backend\team;
use App\Models\Backend\draws;
use App\Models\Backend\teamsPerGroup;
use App\Models\Backend\anaptixi;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

class ChampionshipController extends Controller
{
    public function competitions(){
        $championships= groups::selectRaw('group1.aa_group as id, group1.*, group1.omilos as name, champs.category as category, age_level.Title as ageLevelTitle')
                ->join('champs','champs.champ_id', '=', 'group1.category')
                ->join('age_level','age_level.id', '=', 'group1.age_level')
                ->join('season', 'season.season_id', 'group1.aa_period')
                ->where('season.running',1)
                ->where('group1.active','=','1')
                ->groupBy('group1.aa_group')
                ->orderby('group1.category', 'asc')->get();
        
        return response()->json($championships);
    }

    public function rankingJson($category){
        $ranking=teamsPerGroup::selectRaw('teamspergroup.*, teams.onoma_web as onoma, teams.emblem as emblem, IFNULL(points,0)- IFNULL(poines,0) as points_syn')
                                ->join('teams','teams.team_id','=','teamspergroup.team')
                                ->where('group','=', $category)
                                ->orderBy('points_syn', 'desc')
                                ->orderBy('weight', 'asc')
                                ->orderBy('onoma', 'asc')
                                ->get();
        return response()->json($ranking);
    }

    public function getProgram($group){
        $matches= matches::selectRaw('matches.aa_game as id, matches.date_time , team1.onoma_web as ghp, team2.onoma_web as fil, fields.eps_name as arena,  group1.title as category, group1.category as cat, matches.score_team_1 as score1,  matches.score_team_2 as score2')
                ->join('teams as team1', 'team1.team_id','=', 'matches.team1')
                ->join('teams as team2', 'team2.team_id','=', 'matches.team2')
                ->join('group1', 'group1.aa_group' ,'=','matches.group1')
                ->join('champs', 'group1.category' ,'=','champs.champ_id')
                ->join('fields', 'fields.aa_gipedou','=','matches.court')
                ->where('group1.aa_group',$group)
                ->orderby('matches.match_day', 'asc')
                ->orderby('matches.date_time', 'asc')
                ->get();
         
        return response()->json($matches);
    }
}