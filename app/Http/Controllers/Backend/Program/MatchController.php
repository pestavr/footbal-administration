<?php

namespace App\Http\Controllers\Backend\Program;

use Redirect;
use DB;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Controllers\Controller;
use App\Models\Backend\players;
use App\Models\Backend\matches;
use App\Models\Backend\team;
use App\Models\Backend\season;
use App\Models\Backend\matchPlayers;
use App\Models\Backend\goal;
use App\Models\Backend\penalties;
use App\Models\Backend\subs;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;

class MatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function insert($id){
        $match=matches::selectRaw('matches.aa_game, teams1.emblem as emblem1, teams2.emblem as emblem2, teams1.onoma_web as team1_name, teams2.onoma_web as team2_name, teams1.team_id as team1_id, teams2.team_id as team2_id, fields.sort_name as gipedo, fields.aa_gipedou as id, matches.date_time as date_time, ref.Lastname as ref_last, ref.Firstname as ref_first, help1.Lastname as help1_last, help1.Firstname as help1_first, help2.Lastname as help2_last, help2.Firstname as help2_first, group1.category as cat, matches.round as round, matches.score_team_1 as score_1, matches.score_team_2 as score_2, matches.match_day as match_day, group1.title as category, matches.duration as dur')
                        ->join('fields','matches.court','=','fields.aa_gipedou')
                        ->join('referees as ref', 'matches.referee','=','ref.refaa')
                        ->join('referees as help1', 'matches.helper1','=','help1.refaa')
                        ->join('referees as help2', 'matches.helper2','=','help2.refaa')
                        ->join('group1', 'matches.group1', '=', 'group1.aa_group')
                        ->join('teams as teams1', 'matches.team1','=','teams1.team_id')
                        ->join('teams as teams2', 'matches.team2','=','teams2.team_id')
                        ->where('matches.aa_game','=',$id)
                        ->get();
        foreach($match as $m){
            $players1Sym=DB::select("SELECT players.player_id AS player_id, players.Surname AS Surname, players.Name AS Name, players.F_name AS F_name, players.Birthdate AS Birthdate, SUM( match_players.minutes ) AS sym
                                                FROM (players
                                                LEFT  JOIN match_players ON (match_players.player_id = players.player_id AND players.active =  '1')
                                                INNER JOIN teams ON players.teams_team_id = teams.team_id)
                                                INNER JOIN (SELECT matches.* from matches 
                                                INNER JOIN group1 on matches.group1=group1.aa_group and group1.aa_period='".session('season')."')T1 ON T1.aa_game=match_players.match_id
                                                WHERE players.teams_team_id =  '".$m->team1_id."'
                                                GROUP BY players.player_id
                                                ORDER BY Surname");
            $players1NotSym=DB::select("SELECT players.player_id AS player_id, players.Surname AS Surname, players.Name AS Name, players.F_name AS F_name, players.Birthdate AS Birthdate
                                                    FROM players
                                                    WHERE players.teams_team_id =  '".$m->team1_id."'
                                                    AND players.player_id NOT IN
                                                    (SELECT players.player_id 
                                                    FROM (players
                                                    LEFT  JOIN match_players ON (match_players.player_id = players.player_id AND players.active =  '1')
                                                    INNER JOIN teams ON players.teams_team_id = teams.team_id)
                                                    INNER JOIN (SELECT matches.* from matches 
                                                    INNER JOIN group1 on matches.group1=group1.aa_group and group1.aa_period='".session('season')."')T1 ON T1.aa_game=match_players.match_id
                                                    WHERE players.teams_team_id =  '".$m->team1_id."'
                                                    GROUP BY players.player_id
                                                    ORDER BY Surname)
                                                    ORDER BY Surname");    
            $players2Sym=DB::select("SELECT players.player_id AS player_id, players.Surname AS Surname, players.Name AS Name, players.F_name AS F_name, players.Birthdate AS Birthdate, SUM( match_players.minutes ) AS sym
                                                FROM (players
                                                LEFT  JOIN match_players ON (match_players.player_id = players.player_id AND players.active =  '1')
                                                INNER JOIN teams ON players.teams_team_id = teams.team_id)
                                                INNER JOIN (SELECT matches.* from matches 
                                                INNER JOIN group1 on matches.group1=group1.aa_group and group1.aa_period='".session('season')."')T1 ON T1.aa_game=match_players.match_id
                                                WHERE players.teams_team_id =  '".$m->team2_id."'
                                                GROUP BY players.player_id
                                                ORDER BY Surname");
            $players2NotSym=DB::select("SELECT players.player_id AS player_id, players.Surname AS Surname, players.Name AS Name, players.F_name AS F_name, players.Birthdate AS Birthdate
                                                    FROM players
                                                    WHERE players.teams_team_id =  '".$m->team2_id."'
                                                    AND players.player_id NOT IN
                                                    (SELECT players.player_id 
                                                    FROM (players
                                                    LEFT  JOIN match_players ON (match_players.player_id = players.player_id AND players.active =  '1')
                                                    INNER JOIN teams ON players.teams_team_id = teams.team_id)
                                                    INNER JOIN (SELECT matches.* from matches 
                                                    INNER JOIN group1 on matches.group1=group1.aa_group and group1.aa_period='".session('season')."')T1 ON T1.aa_game=match_players.match_id
                                                    WHERE players.teams_team_id =  '".$m->team2_id."'
                                                    GROUP BY players.player_id
                                                    ORDER BY Surname)
                                                    ORDER BY Surname"); 
        }
        
        return view('backend.program.match.insert', compact('match', 'players1Sym', 'players1NotSym', 'players2Sym', 'players2NotSym'));
    }

    public function edit($id){
            $match=matches::selectRaw('matches.aa_game, teams1.emblem as emblem1, teams2.emblem as emblem2, teams1.onoma_web as team1_name, teams2.onoma_web as team2_name, teams1.team_id as team1_id, teams2.team_id as team2_id, fields.sort_name as gipedo, fields.aa_gipedou as id, matches.date_time as date_time, ref.Lastname as ref_last, ref.Firstname as ref_first, help1.Lastname as help1_last, help1.Firstname as help1_first, help2.Lastname as help2_last, help2.Firstname as help2_first, group1.category as cat, matches.round as round, matches.score_team_1 as score_1, matches.score_team_2 as score_2, matches.match_day as match_day, group1.title as category, matches.duration as dur')
                        ->join('fields','matches.court','=','fields.aa_gipedou')
                        ->join('referees as ref', 'matches.referee','=','ref.refaa')
                        ->join('referees as help1', 'matches.helper1','=','help1.refaa')
                        ->join('referees as help2', 'matches.helper2','=','help2.refaa')
                        ->join('group1', 'matches.group1', '=', 'group1.aa_group')
                        ->join('teams as teams1', 'matches.team1','=','teams1.team_id')
                        ->join('teams as teams2', 'matches.team2','=','teams2.team_id')
                        ->where('matches.aa_game','=',$id)
                        ->get();
            $players=matchPlayers::selectRaw('match_players.*, match_players.position as pos,  players.Name as name, players.Surname as surname')
                        ->join('players', 'match_players.player_id','=','players.player_id')
                        ->where('match_id','=',$id)
                        ->orderBy('match_players.position')
                        ->get();
            $goals=goal::selectRaw('goal_id, goal.mp_id as goal_pl, goal.own_goal as owngoal, goal.min as goal, goal.penalty as penalty, match_players.player_id as player_id, match_players.team_id as team')
                        ->join('match_players','match_players.mp_id','=','goal.mp_id')
                        ->where('match_id','=',$id)
                        ->orderBy('goal.min')
                        ->get();
            $cards=penalties::selectRaw('pen_id, penalties.red as red, penalties.yellow as yellow, match_players.player_id as player_id, match_players.team_id as team')
                        ->join('match_players','match_players.mp_id','=','penalties.mp_id')
                        ->where('match_id','=',$id)
                        ->get();
            $subs=subs::selectRaw('sub_id, min as min, subs_out.player_id as sub_out, subs_in.player_id as sub_in, subs_out.team_id as team') 
                        ->join('match_players as subs_out', 'subs_out.mp_id','=','subs.mp_id_out')
                        ->join('match_players as subs_in', 'subs_in.mp_id','=','subs.mp_id_in')
                        ->where('subs_out.match_id','=',$id)                       
                        ->get();
            return view('backend.program.match.edit', compact('match', 'players', 'goals', 'cards', 'subs'));
    }

        /* Display Add Player Modal*/
    public function addPlayer($id){
        $team=$id;
        return view('backend.program.match.addPlayerModal', compact('team'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saveStats(Request $request,$id)
    {
        $match=matches::getAll($id);
        //$matchPlayer1=array();
        //$matchPlayer2=array();
        $player1in=array();
        $player1out=array();
        $player2in=array();
        $player2out=array();
        
        foreach ($request->player1out as $k => $v) {
            $player1out[$k]=$v;
        }
        foreach ($request->player1in as $k => $v) {
            $player1in[$k]=$v;
        }
        //print_r($request);
        foreach ($request->player1 as $k => $v) {
            $match_player1=new matchPlayers;
            $match_player1->player_id=$v;
            $match_player1->match_id=$id;
            $match_player1->start_list=(intval($k)<11)?1:0;
            $match_player1->position=intval($k)+1;
            $match_player1->minutes=intval($player1out[$k])-intval($player1in[$k]);
            $match_player1->team_id=$match->team1;
            $match_player1->save();
            //$matchPlayer1['pl'.$match_player1->player_id]=$match_player1->mp_id;
            
        }

        foreach ($request->player2out as $k => $v) {
            $player2out[$k]=$v;
        }
        foreach ($request->player2in as $k => $v) {
            $player2in[$k]=$v;
        }

        foreach ($request->player2 as $k => $v) {
            $match_player2=new matchPlayers;
            $match_player2->player_id=$v;
            $match_player2->match_id=$id;
            $match_player2->start_list=(intval($k)<11)?1:0;
            $match_player2->position=intval($k)+1;
            $match_player2->minutes=intval($player2out[$k])-intval($player2in[$k]);
            $match_player2->team_id=$match->team2;
            $match_player2->save();
            //$matchPlayer2['pl'.$match_player2->player_id]=$match_player2->mp_id;
           
        }
        
        if (sizeof($request->scorer1)>0){
             foreach ($request->scorer1 as $k => $v) {
                $goal1=new goal;
                $goal1->mp_id=matchPlayers::getMP($v,$id)->mp_id;
                $goal1->min=request('goalMin1'.$k);
                $goal1->own_goal=request('goalOwn1'.$k);
                $goal1->penalty=request('penalty1'.$k);
                $goal1->save();
             }
        }
         if (sizeof($request->scorer2)>0){
             foreach ($request->scorer2 as $k => $v) {
                $goal2=new goal;
                $goal2->mp_id=matchPlayers::getMP($v,$id)->mp_id;
                $goal2->min=request('goalMin2'.$k);
                $goal2->own_goal=request('goalOwn2'.$k);
                $goal2->penalty=request('penalty2'.$k);
                $goal2->save();
             }
        }
         if (sizeof($request->red1)>0){
             foreach ($request->red1 as $k => $v) {
                $red1=new penalties;
                $red1->mp_id=matchPlayers::getMP($v,$id)->mp_id;
                $red1->red=request('redMin1'.$k);
                $red1->save();
             }
        }
         if (sizeof($request->red2)>0){
             foreach ($request->red2 as $k => $v) {
                $red2=new penalties;
                $red2->mp_id=matchPlayers::getMP($v,$id)->mp_id;
                $red2->red=request('redMin2'.$k);
                $red2->save();
             }
         }
         if(config('settings.yellow')){
             if (sizeof($request->yellow1)>0){
                 foreach ($request->yellow1 as $k => $v) {
                    $yellow1=new penalties;
                    $yellow1->mp_id=matchPlayers::getMP($v,$id)->mp_id;
                    $yellow1->yellow=request('yellowMin1'.$k);
                    $yellow1->save();
                 }
             }
             if (sizeof($request->yellow2)>0){
                 foreach ($request->yellow2 as $k => $v) {
                    $yellow2=new penalties;
                    $yellow2->mp_id=matchPlayers::getMP($v,$id)->mp_id;
                    $yellow2->yellow=request('yellowMin2'.$k);
                    $yellow2->save();
                 }
             }
        }

        if (sizeof($request->subOut1)>0){
            foreach ($request->subOut1 as $k => $v) {
                $sub1=new subs;
                $sub1->mp_id_out=matchPlayers::getMP($v,$id)->mp_id;
                $sub1->mp_id_in=matchPlayers::getMP(request('subIn1'.$k),$id)->mp_id;
                $sub1->min=request('subMin1'.$k);
                $sub1->save();
             }
         }
         if (sizeof($request->subOut2)>0){
             foreach ($request->subOut2 as $k => $v) {
                $sub2=new subs;
                $sub2->mp_id_out=matchPlayers::getMP($v,$id)->mp_id;
                $sub2->mp_id_in=matchPlayers::getMP(request('subIn2'.$k),$id)->mp_id;
                $sub2->min=request('subMin2'.$k);
                $sub2->save();
             }
         }
         $m=matches::findOrFail($id);
         $m->stats=1;
         $m->save();
        return redirect()->route('admin.program.program.index')->withFlashSuccess('Επιτυχής Αποθήκευση');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saveEdit(Request $request,$id)
    {
        $match=matches::getAll($id);
       
        
        if (sizeof($request->scorer1)>0){
             foreach ($request->scorer1 as $k => $v) {
                $goal1=goal::findOrFail(request('goalId1'.$k));
                $goal1->mp_id=matchPlayers::getMP($v,$id)->mp_id;
                $goal1->min=request('goalMin1'.$k);
                $goal1->own_goal=request('goalOwn1'.$k);
                $goal1->penalty=request('penalty1'.$k);
                $goal1->save();
             }
        }
         if (sizeof($request->scorer2)>0){
             foreach ($request->scorer2 as $k => $v) {
                $goal2=goal::findOrFail(request('goalId2'.$k));
                $goal2->mp_id=matchPlayers::getMP($v,$id)->mp_id;
                $goal2->min=request('goalMin2'.$k);
                $goal2->own_goal=request('goalOwn2'.$k);
                $goal2->penalty=request('penalty2'.$k);
                $goal2->save();
             }
        }
         if (sizeof($request->red1)>0){
             foreach ($request->red1 as $k => $v) {
                $red1=penalties::findOrFail(request('redId1'.$k));
                $red1->mp_id=matchPlayers::getMP($v,$id)->mp_id;
                $red1->red=request('redMin1'.$k);
                $red1->save();
             }
        }
         if (sizeof($request->red2)>0){
             foreach ($request->red2 as $k => $v) {
                $red2=penalties::findOrFail(request('redId2'.$k));
                $red2->mp_id=matchPlayers::getMP($v,$id)->mp_id;
                $red2->red=request('redMin2'.$k);
                $red2->save();
             }
         }
         if(config('settings.yellow')){
             if (sizeof($request->yellow1)>0){
                 foreach ($request->yellow1 as $k => $v) {
                    $yellow1=penalties::findOrFail(request('yellowId1'.$k));
                    $yellow1->mp_id=matchPlayers::getMP($v,$id)->mp_id;
                    $yellow1->yellow=request('yellowMin1'.$k);
                    $yellow1->save();
                 }
             }
             if (sizeof($request->yellow2)>0){
                 foreach ($request->yellow2 as $k => $v) {
                    $yellow2=penalties::findOrFail(request('yellowId2'.$k));
                    $yellow2->mp_id=matchPlayers::getMP($v,$id)->mp_id;
                    $yellow2->yellow=request('yellowMin2'.$k);
                    $yellow2->save();
                 }
             }
        }

        if (sizeof($request->subOut1)>0){
            foreach ($request->subOut1 as $k => $v) {
                $sub1=subs::findOrFail(request('subId1'.$k));
                $sub1->mp_id_out=matchPlayers::getMP($v,$id)->mp_id;
                $sub1->mp_id_in=matchPlayers::getMP(request('subIn1'.$k),$id)->mp_id;
                $sub1->min=request('subMin1'.$k);
                $sub1->save();
             }
         }
         if (sizeof($request->subOut2)>0){
             foreach ($request->subOut2 as $k => $v) {
                $sub2=subs::findOrFail(request('subId2'.$k));
                $sub2->mp_id_out=matchPlayers::getMP($v,$id)->mp_id;
                $sub2->mp_id_in=matchPlayers::getMP(request('subIn2'.$k),$id)->mp_id;
                $sub2->min=request('subMin2'.$k);
                $sub2->save();
             }
         }

        return redirect()->back()->withFlashSuccess('Επιτυχής Αποθήκευση');
    }
    /**
     * Deletes all match data.
     *
     * @param  \App\program  $program
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        
        $goal=goal::join('match_players','match_players.mp_id','=','goal.mp_id')->where('match_players.match_id','=',$id)->delete();
        $penalties=penalties::join('match_players','match_players.mp_id','=','penalties.mp_id')->where('match_players.match_id','=',$id)->delete();
        $subs=subs::join('match_players','match_players.mp_id','=','subs.mp_id_out')->where('match_players.match_id','=',$id)->delete();
        $mp=matchPlayers::where('match_id','=',$id)->delete();
        $matches=matches::findOrFail($id);
        $matches->stats=0;
        $matches->save();
        return redirect()->back()->withFlashSuccess('Επιτυχής Διαγραφή');
    }


   

}
