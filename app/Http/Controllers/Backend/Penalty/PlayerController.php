<?php

namespace App\Http\Controllers\Backend\Penalty;

use Redirect;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use App\Models\Backend\matches;
use App\Models\Backend\penaltyPlayer;
use App\Models\Backend\matchPlayers;
use App\Models\Backend\penalties;
use App\Models\Backend\players;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class PlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return view('backend.penalty.player.index');
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function deactivated(){
        return view('backend.penalty.player.deactivated');
    }

    /**
     * returns the penalties history of a player.
     *
     * @return \Illuminate\Http\Response
     */
    public function history()
    {
        $player=request('id');
        $penalties=penaltyPlayer::selectRaw('penalties_players.*, players.Surname as pl_surname, players.Name as pl_name, players.F_name as fname, players.Birthdate as bdate, teams_p.onoma_eps as team_name, penalties_players.reason as reason, penalties_players.player_id as deltio,                              infliction_date, fine, match_days, penalties_players.team_id as team_pen')
            ->join('players', 'penalties_players.player_id','=','players.player_id')
            ->join('teams as teams_p', 'penalties_players.team_id','=','teams_p.team_id')
            ->join('matches' , 'penalties_players.match_id','=', 'matches.aa_game')
            ->where('penalties_players.player_id','=',$player)
            ->orderBy('penalties_players.infliction_date', 'desc')
            ->get();

            return view('backend.penalty.partials.player-history', compact('penalties'));
    }

    /**
     * returns the resent matches of a tema.
     *
     * @return \Illuminate\Http\Response
     */

    public function recentMatches()
    {
        $team=request('id');

        $matches=matches::selectRaw('teams1.onoma_web as team1, teams2.onoma_web as team2, matches.date_time as date_time, matches.aa_game as match_id')
            ->join('teams as teams1' , 'matches.team1','=','teams1.team_id')
            ->join('teams as teams2' , 'matches.team2','=','teams2.team_id')
            ->whereRaw('date_time>="'.Carbon::now()->subDays(120)->format('Y/m/d').'"')
            ->where(function($query) use ($team){
                    $query->where('team1','=', $team)
                          ->orWhere('team2','=', $team);
                    })
            ->whereRaw('score_team_1 is not null')
            ->orderBy('date_time','desc')
            ->get();

            return view('backend.penalty.partials.recentMatches', compact('matches'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

   
    /**
     * Display the specified resource.
     *
     * @param  \App\player  $player
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $player= penaltyPlayer::selectRaw('penalties_players.*, players.Surname as pl_surname, players.Name as pl_name, players.F_name as F_name, teams_p.onoma_eps as team_name, teams1.onoma_eps as onoma_ghp, teams2.onoma_eps as onoma_fil, matches.locked as locked, matches.date_time as date_time, infliction_date, fine, match_days, penalties_players.team_id as team_pen, remain')
                ->join('players', 'penalties_players.player_id','=','players.player_id')
                ->join('teams as teams_p' , 'penalties_players.team_id','=','teams_p.team_id')
                ->join('matches' , 'penalties_players.match_id','=','matches.aa_game')
                ->join('teams as teams1' , 'matches.team1','=','teams1.team_id')
                ->join('teams as teams2' , 'matches.team2','=','teams2.team_id')
                ->join('group1' , 'matches.group1','=', 'group1.aa_group')
                ->where('group1.aa_period','=',session('season'))
                ->orderby('penalties_players.infliction_date', 'desc')
                ->get();
        return Datatables::of($player)
        ->addColumn('actions',function($player){
                //return $herbs->getEditButtonAttribute($herbs->id);
                return view('backend.penalty.partials.playerActions',['id'=>$player->id, 'condition'=>'activate', 'page'=>'player']);
        })
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
  


    public function edit($id)
    {
        $players= penaltyPlayer::selectRaw('penalties_players.*, players.Surname as pl_surname, players.Name as pl_name,
                                teams_p.onoma_eps as team_name, teams_p.team_id as team_id, players.Birthdate as Birthdate, F_name as F_name,  teams1.onoma_eps as onoma_ghp, teams2.onoma_eps as onoma_fil, matches.locked as locked, 
                                matches.date_time as date_time,matches.aa_game as match_id, infliction_date, fine, match_days, penalties_players.team_id as team_pen, remain')
                ->join('players', 'penalties_players.player_id','=','players.player_id')
                ->join('teams as teams_p' , 'penalties_players.team_id','=','teams_p.team_id')
                ->join('matches' , 'penalties_players.match_id','=','matches.aa_game')
                ->join('teams as teams1' , 'matches.team1','=','teams1.team_id')
                ->join('teams as teams2' , 'matches.team2','=','teams2.team_id')
                ->join('group1' , 'matches.group1','=', 'group1.aa_group')
                ->where('penalties_players.id','=',$id)
                ->orderby('penalties_players.infliction_date', 'desc')
                ->get();

        return view('backend.penalty.player.edit', compact('players'));
    }

    public function show_modal($id)
    {
        $players= penaltyPlayer::selectRaw('penalties_players.*, players.player_id as player_id, players.Surname as pl_surname, players.Name as pl_name,
                                teams_p.onoma_eps as team_name, F_name as F_name,  teams1.onoma_eps as onoma_ghp, teams2.onoma_eps as onoma_fil, matches.locked as locked, 
                                matches.date_time as date_time, infliction_date, fine, match_days, penalties_players.team_id as team_pen, remain')
                ->join('players', 'penalties_players.player_id','=','players.player_id')
                ->join('teams as teams_p' , 'penalties_players.team_id','=','teams_p.team_id')
                ->join('matches' , 'penalties_players.match_id','=','matches.aa_game')
                ->join('teams as teams1' , 'matches.team1','=','teams1.team_id')
                ->join('teams as teams2' , 'matches.team2','=','teams2.team_id')
                ->join('group1' , 'matches.group1','=', 'group1.aa_group')
                ->where('penalties_players.id','=',$id)
                ->orderby('penalties_players.infliction_date', 'desc')
                ->get();

        return view('backend.penalty.player.modal-content', compact('players'));
    }

     public function insert()
    {
        
        return view('backend.penalty.player.insert');
    }

    public function insertRedPenalty($id,$match)
    {
        $player= players::selectRaw('players.*, teams.onoma_eps as team_name, teams.team_id as team_id')
                ->join('teams' , 'players.teams_team_id','=','teams.team_id')
                ->where('player_id','=',$id)
                ->get();
        $match= matches::selectRaw('matches.*, teams1.onoma_eps as onoma_ghp, teams2.onoma_eps as onoma_fil')
                ->join('teams as teams1' , 'matches.team1','=','teams1.team_id')
                ->join('teams as teams2' , 'matches.team2','=','teams2.team_id')
                ->where('aa_game','=',$match)
                ->get();
        return view('backend.penalty.player.insertRedPenalty', compact('player', 'match'));
    }

    public function per_team($id)
    {
        $team_id=$id;
        return view('backend.penalty.team.player', compact('team_id'));
    }

    public function show_per_team($id)
    {
        $player= player::selectRaw('player.*, teams.onoma_web')
                ->join('teams','teams.team_id','=','player.teams_team_id')
                ->where('player.active','=','1')
                ->where('teams_team_id','=',$id)
                ->orderby('player.Surname', 'asc');
        return Datatables::of($player)
        ->addColumn('actions',function($player){
                //return $herbs->getEditButtonAttribute($herbs->id);
                return view('backend.includes.partials.actions',['id'=>$player->player_id, 'condition'=>'activate', 'page'=>'player']);
        })
        ->rawColumns(['actions'])
        ->make(true);
        
    } 
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\referees  $referees
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $this->validate(request(), [
                'player_id'=> 'required',
                'match_id'=> 'required',
                'infliction_date'=>'date_format:"d/m/Y"|required',
                'team_id'=>'required',
                'fine'=>'numeric|nullable',
                'match_days'=>'numeric|nullable',
            ]);

        $format = 'd/m/Y';

        $date = Carbon::createFromFormat($format, request('infliction_date'));
        $player= penaltyPlayer::findOrFail($id);
                      
        $player->player_id= request('player_id');              
        $player->team_id= request('team_id');
        $player->match_id= request('match_id');
        $player->infliction_date= Carbon::parse($date)->format('Y/m/d');
        $player->reason= request('reason');
        $player->decision_num= request('decision_num');
        $player->fine= request('fine');
        $player->match_days= request('match_days');
        $player->kind_of_days= request('kind_of_days');
        $player->reproof= request('reproof');
        $player->remain= request('remain');
        $player->save();
        /*History Log record*/
        //event(new refereesUpdate($referees));

        return redirect()->back()->withFlashSuccess('Επιτυχής Αποθήκευση');

    }

        /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\referees  $referees
     * @return \Illuminate\Http\Response
     */
    public function do_insert()
    {
        $this->validate(request(), [
                'player_id'=> 'required',
                'match_id'=> 'required',
                'infliction_date'=>'date_format:"d/m/Y"|required',
                'team_id'=>'required',
                'fine'=>'numeric|nullable',
                'match_days'=>'numeric|nullable',
            ]);

        $format = 'd/m/Y';

        $date = Carbon::createFromFormat($format, request('infliction_date'));
        $player= new penaltyPlayer;
                      
        $player->player_id= request('player_id');              
        $player->team_id= request('team_id');
        $player->match_id= request('match_id');
        $player->infliction_date= Carbon::parse($date)->format('Y/m/d');
        $player->reason= request('reason');
        $player->decision_num= request('decision_num');
        $player->fine= request('fine');
        $player->match_days= request('match_days');
        $player->kind_of_days= request('kind_of_days');
        $player->reproof= request('reproof');
        $player->remain= request('match_days');
        $player->save();
        /*History Log record*/
        //event(new playerUpdate($player));

        return Redirect::route('admin.penalty.player.index');

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\referees  $referees
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $penaltyPlayer= penaltyPlayer::findOrFail($id)->delete();


       return Redirect::route('admin.penalty.player.index');
    }

    public function getRed()
    {
        $player= matchPlayers::selectRaw('match_players.*, players.Surname as playerSurname, players.Name as playerName, team1.onoma_web as teamName1, team2.onoma_web as teamName2, matches.date_time as match_date, playersTeam.onoma_web as team_name')
                ->join('matches','matches.aa_game','=','match_players.match_id')
                ->join('players','players.player_id','=','match_players.player_id')
                ->join('teams as playersTeam','playersTeam.team_id','=','players.teams_team_id')
                ->join('teams as team1', 'team1.team_id','=', 'matches.team1')
                ->join('teams as team2', 'team2.team_id','=', 'matches.team2')
                ->join('group1' , 'matches.group1','=', 'group1.aa_group')
                ->join('penalties','penalties.mp_id','=','match_players.mp_id')
                ->where('group1.aa_period','=',session('season'))
                ->whereNotIn(DB::raw('(match_players.match_id, match_players.player_id)'), function($q){
                    $q->select('penalties_players.match_id', 'penalties_players.player_id')->from('penalties_players');
                })
                ->where('penalties.red','>','0')
                ->groupBy('match_players.player_id')
                ->orderBy('players.Surname', 'asc');
        return Datatables::of($player)
        ->addColumn('match_date',function($player){
                return Carbon::parse($player->match_date)->format('d/m/Y');
        })
        ->addColumn('player',function($player){
                return $player->playerSurname.' - '.$player->playerName;
        })
        ->addColumn('match',function($player){
                return $player->teamName1.' - '.$player->teamName2;
        })
        ->addColumn('actions',function($player){
                //return $herbs->getEditButtonAttribute($herbs->id);
                return view('backend.penalty.partials.playerRedActions',['id'=>$player->player_id, 'match'=>$player->match_id]);
        })
        ->rawColumns(['actions'])
        ->make(true);
        
    } 


}
