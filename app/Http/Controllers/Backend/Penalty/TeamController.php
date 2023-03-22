<?php

namespace App\Http\Controllers\Backend\Penalty;

use Redirect;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use App\Models\Backend\matches;
use App\Models\Backend\team;
use App\Models\Backend\penaltyTeam;
use App\Models\Backend\teamsPerGroup;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return view('backend.penalty.team.index');
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function deactivated(){
        return view('backend.penalty.team.deactivated');
    }

    /**
     * returns the penalties history of a player.
     *
     * @return \Illuminate\Http\Response
     */
    public function history()
    {
        $team=request('id');
        $penalties=penaltyTeam::selectRaw('penalties_teams.*, teams_p.onoma_eps as team_name, penalties_teams.reason as reason, infliction_date, fine, match_days, penalties_teams.team_id as team_pen')
            ->join('teams as teams_p', 'penalties_teams.team_id','=','teams_p.team_id')
            ->join('matches' , 'penalties_teams.match_id','=', 'matches.aa_game')
            ->where('penalties_teams.team_id','=',$team)
            ->orderBy('penalties_teams.infliction_date', 'desc')
            ->get();

            return view('backend.penalty.partials.team-history', compact('penalties'));
    }

    /**
     * returns the resent matches of a tema.
     *
     * @return \Illuminate\Http\Response
     */

    public function recentMatches()
    {
        $team=request('id');
        $teams = team::where('parent', $team)->pluck('team_id')->toArray();
        array_push($teams, $team);
        $matches=matches::selectRaw('teams1.onoma_web as team1, teams2.onoma_web as team2, matches.date_time as date_time, matches.aa_game as match_id')
            ->join('teams as teams1' , 'matches.team1','=','teams1.team_id')
            ->join('teams as teams2' , 'matches.team2','=','teams2.team_id')
            ->whereRaw('date_time>="'.Carbon::now()->subDays(120)->format('Y/m/d').'"')
            ->where(function($query) use ($teams){
                    $query->whereIn('team1', $teams)
                          ->orWhereIn('team2', $teams);
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
     * @param  \App\player  $team
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $team= penaltyTeam::selectRaw('penalties_teams.*, teams_p.onoma_eps as team_name, teams1.onoma_eps as onoma_ghp, teams2.onoma_eps as onoma_fil,matches.date_time as date_time, infliction_date, fine, match_days, pointsoff, penalties_teams.team_id as team_pen, remain, matches.locked as locked')
                ->join('teams as teams_p' , 'penalties_teams.team_id','=','teams_p.team_id')
                ->join('matches' , 'penalties_teams.match_id','=','matches.aa_game')
                ->join('teams as teams1' , 'matches.team1','=','teams1.team_id')
                ->join('teams as teams2' , 'matches.team2','=','teams2.team_id')
                ->join('group1' , 'matches.group1','=', 'group1.aa_group')
                ->where('group1.aa_period','=',session('season'))
                ->orderby('penalties_teams.infliction_date', 'desc')
                ->get();
        return Datatables::of($team)
        ->addColumn('actions',function($team){
                //return $herbs->getEditButtonAttribute($herbs->id);
                return view('backend.penalty.partials.teamActions',['id'=>$team->id, 'condition'=>'activate', 'page'=>'player']);
        })
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
  


    public function edit($id)
    {
        $teams= penaltyTeam::selectRaw('penalties_teams.*, teams_p.onoma_eps as team_name, teams_p.team_id as team_id,   teams1.onoma_eps as onoma_ghp, teams2.onoma_eps as onoma_fil, matches.locked as locked, matches.date_time as date_time,  matches.aa_game as match_id, infliction_date, reason, decision_num, fine, match_days, pointsoff, description, remain')
                ->join('teams as teams_p' , 'penalties_teams.team_id','=','teams_p.team_id')
                ->join('matches' , 'penalties_teams.match_id','=','matches.aa_game')
                ->join('teams as teams1' , 'matches.team1','=','teams1.team_id')
                ->join('teams as teams2' , 'matches.team2','=','teams2.team_id')
                ->join('group1' , 'matches.group1','=', 'group1.aa_group')
                ->where('penalties_teams.id','=',$id)
                ->orderby('penalties_teams.infliction_date', 'desc')
                ->get();

        return view('backend.penalty.team.edit', compact('teams'));
    }

    public function show_modal($id)
    {
        $teams= penaltyTeam::selectRaw('penalties_teams.*, teams_p.onoma_eps as team_name, teams_p.team_id as team_id,   teams1.onoma_eps as onoma_ghp, teams2.onoma_eps as onoma_fil, matches.locked as locked, matches.date_time as date_time, matches.aa_game as match_id, infliction_date, reason, decision_num, fine, match_days, pointsoff, description, remain')
                ->join('teams as teams_p' , 'penalties_teams.team_id','=','teams_p.team_id')
                ->join('matches' , 'penalties_teams.match_id','=','matches.aa_game')
                ->join('teams as teams1' , 'matches.team1','=','teams1.team_id')
                ->join('teams as teams2' , 'matches.team2','=','teams2.team_id')
                ->join('group1' , 'matches.group1','=', 'group1.aa_group')
                ->where('penalties_teams.id','=',$id)
                ->orderby('penalties_teams.infliction_date', 'desc')
                ->get();

        return view('backend.penalty.team.modal-content', compact('teams'));
    }

     public function insert()
    {
        
        return view('backend.penalty.team.insert');
    }

    public function per_team($id)
    {
        $team_id=$id;
        return view('backend.penalty.team.player', compact('team_id'));
    }

    public function show_per_team($id)
    {
        $team= player::selectRaw('player.*, teams.onoma_web')
                ->join('teams','teams.team_id','=','player.teams_team_id')
                ->where('player.active','=','1')
                ->where('teams_team_id','=',$id)
                ->orderby('player.Surname', 'asc');
        return Datatables::of($team)
        ->addColumn('actions',function($team){
                //return $herbs->getEditButtonAttribute($herbs->id);
                return view('backend.includes.partials.actions',['id'=>$team->player_id, 'condition'=>'activate', 'page'=>'player']);
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
                'match_id'=> 'required',
                'infliction_date'=>'date_format:"d/m/Y"|required',
                'team'=>'required',
                'fine'=>'numeric|nullable',
                'match_days'=>'numeric|nullable',
            ]);

        $format = 'd/m/Y';

        $date = Carbon::createFromFormat($format, request('infliction_date'));
        $team= penaltyTeam::findOrFail($id);
        if (request('pointsoff')<>$team->pointsoff){
            try{
                $match=matches::findOrFail(request('match_id'));
                $tPG=teamsPerGroup::where('team','=',request('team'))->where('group','=',$match->group1)->first();
                $tPG->increment('poines', (intval(request('pointsoff'))-intval($team->pointsoff)));
            }catch (\Exception $e) {
               return $e->getMessage();
            }
        }                        
        $team->team_id= request('team');
        $team->match_id= request('match_id');
        $team->infliction_date= Carbon::parse($date)->format('Y/m/d');
        $team->reason= request('reason');
        $team->decision_num= request('decision_num');
        $team->fine= request('fine');
        $team->pointsoff= request('pointsoff');
        $team->match_days= request('match_days');
        $team->description= request('description');
        $team->remain= request('remain');
        
        $team->save();
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
                'match_id'=> 'required',
                'infliction_date'=>'date_format:"d/m/Y"|required',
                'team'=>'required',
                'fine'=>'numeric|nullable',
                'match_days'=>'numeric|nullable',
            ]);

        $format = 'd/m/Y';

        $date = Carbon::createFromFormat($format, request('infliction_date'));
        $team= new penaltyTeam;
                      
        $team->team_id= request('team');
        $team->match_id= request('match_id');
        $team->infliction_date= Carbon::parse($date)->format('Y/m/d');
        $team->reason= request('reason');
        $team->decision_num= request('decision_num');
        $team->fine= request('fine');
        $team->pointsoff= request('pointsoff');
        $team->match_days= request('match_days');
        $team->description= request('description');
        $team->remain= request('match_days');
        $team->save();

        if (request('pointsoff')>0){
            try{
                $match=matches::findOrFail(request('match_id'));
                $tPG=teamsPerGroup::where('team','=',request('team'))->where('group','=',$match->group1)->first();
                $tPG->increment('poines', request('pointsoff'));
            }catch (\Exception $e) {
               return $e->getMessage();
            }
        }
        /*History Log record*/
        //event(new playerUpdate($team));

        return Redirect::route('admin.penalty.team.index');

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\referees  $referees
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $penaltyTeam= penaltyTeam::findOrFail($id);
        if ($penaltyTeam->pointsoff>0){
            $match=matches::findOrFail($penaltyTeam->match_id);
            $tPG=teamsPerGroup::where('team','=',$penaltyTeam->team_id)->where('group','=',$match->group1)->first();
            $tPG->decrement('poines', $penaltyTeam->pointsoff);
        }
        $penaltyTeam->delete();

       return Redirect::route('admin.penalty.team.index');
    }


}
