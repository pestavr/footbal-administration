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
use App\Models\Backend\penaltyOfficial;
use App\Models\Backend\penaltyTeam;
use App\Models\Backend\penaltyPlayer;
use Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;

class PenaltiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function teamsIndex(){
        return view('backend.prints.penalties.teamsIndex');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function playersIndex(){
        return view('backend.prints.penalties.playersIndex');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function OfficialsIndex(){
        return view('backend.prints.penalties.οfficialsIndex');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function allIndex(){
        return view('backend.prints.penalties.allIndex');
    }

     //Omades ana Omilo 
    public function getTeamsPenalties(){

        $date_from= request('date_from');
        $date_to= request('date_to');
        $team1= request('team');

        
        session()->put('team', $team1);

        $team= penaltyTeam::selectRaw('penalties_teams.*, teams_p.onoma_eps as team_name, teams1.onoma_eps as onoma_ghp, teams2.onoma_eps as onoma_fil, matches.date_time as date_time, penalties_teams.team_id as team_pen,  matches.locked as locked')
                ->join('teams as teams_p' , 'penalties_teams.team_id','=','teams_p.team_id')
                ->join('matches' , 'penalties_teams.match_id','=','matches.aa_game')
                ->join('teams as teams1' , 'matches.team1','=','teams1.team_id')
                ->join('teams as teams2' , 'matches.team2','=','teams2.team_id')
                ->join('group1' , 'matches.group1','=', 'group1.aa_group')
                ->where('group1.aa_period','=',session('season'))
                ->orderby('penalties_teams.infliction_date', 'desc');
        if(($date_to!=null) && ($date_from!=null)){
             $format = 'd/m/Y';
             $date_from = Carbon::createFromFormat($format, $date_from);
             $date_to = Carbon::createFromFormat($format, $date_to);
             $team->whereBetween('penalties_teams.infliction_date',array($date_from, $date_to)); 
        }
        if(($team1!=null)){
            $team->where('penalties_teams.team_id','=',$team1);
         }

        return Datatables::of($team)
         ->addColumn('player', function($team){
                return $team->pl_surname.' '.$team->pl_name;
            })
         ->addColumn('match', function($team){
                return $team->onoma_ghp.' - '.$team->onoma_fil;
            })
         ->addColumn('inf_date', function($team){
                return Carbon::parse($team->infliction_date)->format('d/m/Y');
            })
        ->rawColumns(['actions'])
        ->make(true);
    }

     public function getPlayersPenalties(){

        $date_from= request('date_from');
        $date_to= request('date_to');
        $team1= request('team');

        
        session()->put('team', $team1);

        $player= penaltyPlayer::selectRaw('penalties_players.*, players.Surname as pl_surname, players.Name as pl_name, players.F_name as F_name, teams_p.onoma_eps as team_name, teams1.onoma_eps as onoma_ghp, teams2.onoma_eps as onoma_fil, matches.locked as locked, matches.date_time as date_time,  penalties_players.team_id as team_pen')
                ->join('players', 'penalties_players.player_id','=','players.player_id')
                ->join('teams as teams_p' , 'penalties_players.team_id','=','teams_p.team_id')
                ->join('matches' , 'penalties_players.match_id','=','matches.aa_game')
                ->join('teams as teams1' , 'matches.team1','=','teams1.team_id')
                ->join('teams as teams2' , 'matches.team2','=','teams2.team_id')
                ->join('group1' , 'matches.group1','=', 'group1.aa_group')
                ->where('group1.aa_period','=',session('season'))
                ->orderby('penalties_players.infliction_date', 'desc');

        if(($date_to!=null) && ($date_from!=null)){
             $format = 'd/m/Y';
             $date_from = Carbon::createFromFormat($format, $date_from);
             $date_to = Carbon::createFromFormat($format, $date_to);
             $player->whereBetween('penalties_players.infliction_date',array($date_from, $date_to)); 
        }
        if(($team1!=null)){
            $player->where('penalties_players.team_id','=',$team1);
         }
        return Datatables::of($player)
         ->addColumn('player', function($player){
                return $player->pl_surname.' '.$player->pl_name;
            })
         ->addColumn('match', function($player){
                return $player->onoma_ghp.' - '.$player->onoma_fil;
            })
         ->addColumn('inf_date', function($player){
                return Carbon::parse($player->infliction_date)->format('d/m/Y');
            })
        ->rawColumns(['actions'])
        ->make(true);
        

        
    }

    public function getOfficialsPenalties(){

        $date_from= request('date_from');
        $date_to= request('date_to');
        $team1= request('team');

        
        session()->put('team', $team1);

        $official= penaltyOfficial::selectRaw('penalties_officials.*, teams_p.onoma_eps as team_name, teams1.onoma_eps as onoma_ghp, teams2.onoma_eps as onoma_fil,matches.date_time as date_time,   penalties_officials.team_id as team_pen,  matches.locked as locked')
                ->join('teams as teams_p' , 'penalties_officials.team_id','=','teams_p.team_id')
                ->join('matches' , 'penalties_officials.match_id','=','matches.aa_game')
                ->join('teams as teams1' , 'matches.team1','=','teams1.team_id')
                ->join('teams as teams2' , 'matches.team2','=','teams2.team_id')
                ->join('group1' , 'matches.group1','=', 'group1.aa_group')
                ->where('group1.aa_period','=',session('season'))
                ->orderby('penalties_officials.infliction_date', 'desc');


        if(($date_to!=null) && ($date_from!=null)){
             $format = 'd/m/Y';
             $date_from = Carbon::createFromFormat($format, $date_from);
             $date_to = Carbon::createFromFormat($format, $date_to);
             $official->whereBetween('penalties_officials.infliction_date',array($date_from, $date_to)); 
        }
        if(($team1!=null)){
            $official->where('penalties_officials.team_id','=',$team1);
         }

        return Datatables::of($official)
         ->addColumn('official', function($official){
                return $official->name.' ('.$official->title.')';
            })
         ->addColumn('match', function($official){
                return $official->onoma_ghp.' - '.$official->onoma_fil;
            })
         ->addColumn('inf_date', function($official){
                return Carbon::parse($official->infliction_date)->format('d/m/Y');
            })
        ->make(true);

        
    }

         //Omades ana Omilo 
    public function getAllPenalties(){

        $date_from= request('date_from');
        $date_to= request('date_to');
        $team1= request('team');

        
        session()->put('team', $team1);
        $player= DB::table('penalties_players')
                ->selectRaw('players.Surname as pl_surname, 
                players.Name as pl_name, 
                penalties_players.reason as reason, 
                penalties_players.fine as fine, 
                penalties_players.match_days as match_days, 
                penalties_players.kind_of_days as kind_of_days, "" as pointsoff, 
                teams_p.onoma_eps as team_name, 
                teams1.onoma_eps as onoma_ghp, 
                teams2.onoma_eps as onoma_fil, 
                penalties_players.infliction_date as dateTime,  
                penalties_players.team_id as team_pen,
                matches.locked as locked')
                ->join('players', 'penalties_players.player_id','=','players.player_id')
                ->join('teams as teams_p' , 'penalties_players.team_id','=','teams_p.team_id')
                ->join('matches' , 'penalties_players.match_id','=','matches.aa_game')
                ->join('teams as teams1' , 'matches.team1','=','teams1.team_id')
                ->join('teams as teams2' , 'matches.team2','=','teams2.team_id')
                ->join('group1' , 'matches.group1','=', 'group1.aa_group')
                ->where('group1.aa_period','=',session('season'))
                ->orderby('penalties_players.infliction_date', 'desc');
                if(($date_to!=null) && ($date_from!=null)){
                     $format = 'd/m/Y';
                     \Log::info($date_from.' - '.$date_to);
                     $dateFrom = Carbon::createFromFormat($format, $date_from)->format('Y-m-d');
                     $dateTo = Carbon::createFromFormat($format, $date_to)->format('Y-m-d');
                     $player->whereBetween('penalties_players.infliction_date',array($dateFrom, $dateTo)); 
                }
                if(($team1!=null)){
                    $player->where('penalties_players.team_id','=',$team1);
                }
        $official= DB::table('penalties_officials')
                ->selectRaw('penalties_officials.name as pl_surname, 
                penalties_officials.title as pl_name, 
                penalties_officials.reason as reason, 
                penalties_officials.fine as fine, 
                penalties_officials.match_days as match_days, 
                penalties_officials.kind_of_days as kind_of_days, "" as pointsoff, 
                teams_p.onoma_eps as team_name, 
                teams1.onoma_eps as onoma_ghp, 
                teams2.onoma_eps as onoma_fil, 
                penalties_officials.infliction_date as dateTime,   
                penalties_officials.team_id as team_pen, 
                matches.locked as locked')
                ->join('teams as teams_p' , 'penalties_officials.team_id','=','teams_p.team_id')
                ->join('matches' , 'penalties_officials.match_id','=','matches.aa_game')
                ->join('teams as teams1' , 'matches.team1','=','teams1.team_id')
                ->join('teams as teams2' , 'matches.team2','=','teams2.team_id')
                ->join('group1' , 'matches.group1','=', 'group1.aa_group')
                ->where('group1.aa_period','=',session('season'))
                ->orderby('penalties_officials.infliction_date', 'desc');
                if(($date_to!=null) && ($date_from!=null)){
                     $format = 'd/m/Y';
                     \Log::info($date_from.' - '.$date_to);
                     $dateFrom = Carbon::createFromFormat($format, $date_from)->format('Y-m-d');
                     $dateTo = Carbon::createFromFormat($format, $date_to)->format('Y-m-d');
                     $official->whereBetween('penalties_officials.infliction_date',array($dateFrom, $dateTo)); 
                }
                if(($team1!=null)){
                    $official->where('penalties_officials.team_id','=',$team1);
                }
        $team= DB::table('penalties_teams')
                ->selectRaw('"-" as pl_surname, " " as pl_name, 
                penalties_teams.reason as reason, 
                penalties_teams.fine as fine, 
                penalties_teams.match_days as match_days, 
                "1" as kind_of_days, 
                penalties_teams.pointsoff as pointsoff, 
                teams_p.onoma_eps as team_name, 
                teams1.onoma_eps as onoma_ghp, 
                teams2.onoma_eps as onoma_fil, 
                penalties_teams.infliction_date as dateTime, 
                penalties_teams.team_id as team_pen,  
                matches.locked as locked')
                ->join('teams as teams_p' , 'penalties_teams.team_id','=','teams_p.team_id')
                ->join('matches' , 'penalties_teams.match_id','=','matches.aa_game')
                ->join('teams as teams1' , 'matches.team1','=','teams1.team_id')
                ->join('teams as teams2' , 'matches.team2','=','teams2.team_id')
                ->join('group1' , 'matches.group1','=', 'group1.aa_group')
                ->where('group1.aa_period','=',session('season'))
                ->orderby('penalties_teams.infliction_date', 'desc')
                ->union($player)
                ->union($official);
        if(($date_to!=null) && ($date_from!=null)){
             $format = 'd/m/Y';
             \Log::info($date_from.' - '.$date_to);
             $dateFrom = Carbon::createFromFormat($format, $date_from)->format('Y-m-d');
             $dateTo = Carbon::createFromFormat($format, $date_to)->format('Y-m-d');
             $team->whereBetween('penalties_teams.infliction_date',array($dateFrom, $dateTo)); 
        }
        if(($team1!=null)){
            $team->where('penalties_teams.team_id','=',$team1);
         }
         $team->get();
        return Datatables::of($team)
         ->addColumn('player', function($team){
                return $team->pl_surname.' '.$team->pl_name;
            })
         ->addColumn('match', function($team){
                return $team->onoma_ghp.' - '.$team->onoma_fil;
            })
         ->addColumn('inf_date', function($team){
                return Carbon::parse($team->dateTime)->format('d/m/Y');
            })
        ->rawColumns(['actions'])
        ->make(true);
    }


}
