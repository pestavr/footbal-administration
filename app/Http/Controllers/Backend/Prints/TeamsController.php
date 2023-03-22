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
use Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;

class TeamsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return view('backend.prints.teams.index');
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function program(){
        return view('backend.prints.teams.program');
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function players(){
        return view('backend.prints.teams.players');
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
        $ageLevel= request('ageLevel');

        session()->put('category', $category);
        session()->put('ageLevel', $ageLevel);

        $teams= team::selectRaw('teams.team_id as id, teams.onoma_web as name, teams.tel as tel, teams.email as email, age_level.Age_Level_Title as Age_Level, age_level.Title as alTitle, group1.title as omilos')
                ->join('age_level', 'age_level.id','=','teams.age_level')
                ->leftJoin('teamspergroup', 'teams.team_id','=','teamspergroup.team')
                ->leftJoin('group1', 'teamspergroup.group','=', 'group1.aa_group')
                ->where('group1.aa_period','=', session('season'))
                ->groupBy('teams.team_id')
                ->orderby('teams.onoma_web', 'asc');
        if ($category!=null)        
            $teams->where('group1.aa_group','=',$category);
        if ($ageLevel!=null)
            $teams->where('teams.age_level','=',$ageLevel);  
        $response= Datatables::of($teams)
        ->addIndexColumn()
        ->addColumn('ageLevel', function($teams){
                return $teams->Age_Level.' ('.$teams->alTitle.')';
            });
        
        $response=$response->make(true);
        return $response;
    }

    //Programma kathe Omadas 
    public function getMatches(){

        $team= request('team');
        
        session()->put('team', $team);

        $matches= matches::selectRaw('matches.aa_game as id, matches.*, team1.onoma_web as ghp, team2.onoma_web as fil, fields.eps_name as arena, fields.aa_gipedou as arena_id, group1.title as category,  group1.category as cat, group1.locked as groupLocked,  champs.flexible as flexible, matches.score_team_1 as score1, matches.score_team_2 as score2, matches.publ as prog_publ, matches.published as ref_publ, matches.publ_doc as doc_publ, matches.publ_ref_obs as ref_obs_publ, "-" as dash')
                ->join('teams as team1', 'team1.team_id','=', 'matches.team1')
                ->join('teams as team2', 'team2.team_id','=', 'matches.team2')
                ->join('group1', 'group1.aa_group' ,'=','matches.group1')
                ->join('champs', 'group1.category' ,'=','champs.champ_id')
                ->join('fields', 'fields.aa_gipedou','=','matches.court')
                ->where('group1.aa_period','=', session('season'))
                ->where(function($query) use ($team){
                        $query->where('matches.team1','=', $team)
                              ->orWhere('matches.team2','=', $team);
                        })
                ->orderby('matches.date_time', 'asc')
                ->get();
        $response= Datatables::of($matches)
       
        ->addColumn('match', function($matches){
                return $matches->ghp.' - '.$matches->fil;
            })
        ->addColumn('date', function($matches){
            if ($matches->date_time==config('default.datetime')){
                $date='-';
                $dataDate=Carbon::now()->format('d/m/Y H:i');
            }else{
                $date=Carbon::parse($matches->date_time)->format('d/m/Y H:i');
                $dataDate=Carbon::parse($matches->date_time)->format('d/m/Y H:i');
            }
            return $date;
            })
        ->addColumn('score', function($matches){
                return $matches->score_team_1.' - '.$matches->score_team_2;
            })
        ->addColumn('code', function($matches){
                return '#'.$matches->aa_game.'#';
            });

        $response=$response->make(true);
        return $response;
    }

    //Podosfairistes kathe Omadas 
    public function getPlayers(){

        $team= request('team');
        $active= request('active');
        
        session()->put('team', $team);

        $players= players::selectRaw('players.*, teams.onoma_web, YEAR(Birthdate) as birthYear')
                ->join('teams','teams.team_id','=','players.teams_team_id')
                ->where('teams_team_id','=',$team)
                ->orderby('players.Surname', 'asc');
        if ($active!=null)
            $players->where('players.active','=', $active);
        return Datatables::of($players)
        ->addColumn('actions',function($players){
                //return $herbs->getEditButtonAttribute($herbs->id);
                return view('backend.includes.partials.actions',['id'=>$players->player_id, 'condition'=>'activate', 'page'=>'players']);
        })
        ->rawColumns(['actions'])
        ->make(true);
    }




   

}
