<?php

namespace App\Http\Controllers\Backend\Penalty;

use Redirect;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use App\Models\Backend\matches;
use App\Models\Backend\penaltyOfficial;
use Illuminate\Http\Request;
use Carbon\Carbon;

class OfficialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return view('backend.penalty.official.index');
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function deactivated(){
        return view('backend.penalty.official.deactivated');
    }

    /**
     * returns the penalties history of a player.
     *
     * @return \Illuminate\Http\Response
     */
   

    /**
     * returns the resent matches of a tema.
     *
     * @return \Illuminate\Http\Response
     */

    public function recentMatches()
    {
        $official=request('id');

        $matches=matches::selectRaw('teams1.onoma_web as team1, teams2.onoma_web as team2, matches.date_time as date_time, matches.aa_game as match_id')
            ->join('teams as teams1' , 'matches.team1','=','teams1.team_id')
            ->join('teams as teams2' , 'matches.team2','=','teams2.team_id')
            ->whereRaw('date_time>="'.Carbon::now()->subDays(120)->format('Y/m/d').'"')
            ->where(function($query) use ($official){
                    $query->where('team1','=', $official)
                          ->orWhere('team2','=', $official);
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
     * @param  \App\player  $official
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $official= penaltyOfficial::selectRaw('penalties_officials.*, teams_p.onoma_eps as team_name, teams1.onoma_eps as onoma_ghp, teams2.onoma_eps as onoma_fil,matches.date_time as date_time, infliction_date, fine, match_days,  penalties_officials.team_id as team_pen, remain, matches.locked as locked')
                ->join('teams as teams_p' , 'penalties_officials.team_id','=','teams_p.team_id')
                ->join('matches' , 'penalties_officials.match_id','=','matches.aa_game')
                ->join('teams as teams1' , 'matches.team1','=','teams1.team_id')
                ->join('teams as teams2' , 'matches.team2','=','teams2.team_id')
                ->join('group1' , 'matches.group1','=', 'group1.aa_group')
                ->where('group1.aa_period','=',session('season'))
                ->orderby('penalties_officials.infliction_date', 'desc')
                ->get();
        return Datatables::of($official)
        ->addColumn('actions',function($official){
                //return $herbs->getEditButtonAttribute($herbs->id);
                return view('backend.penalty.partials.officialActions',['id'=>$official->id, 'condition'=>'activate', 'page'=>'player']);
        })
         ->addColumn('official', function($official){
                return $official->name.' ('.$official->title.')';
            })
         ->addColumn('match', function($official){
                return $official->onoma_ghp.' - '.$official->onoma_fil;
            })
         ->addColumn('inf_date', function($official){
                return Carbon::parse($official->infliction_date)->format('d/m/Y');
            })
        ->rawColumns(['actions'])
        ->make(true);
        
    } 
  


    public function edit($id)
    {
        $officials= penaltyOfficial::selectRaw('penalties_officials.*, teams_p.onoma_eps as team_name, teams_p.team_id as team_id,   teams1.onoma_eps as onoma_ghp, teams2.onoma_eps as onoma_fil, matches.locked as locked, matches.date_time as date_time,  matches.aa_game as match_id, infliction_date, reason, decision_num, fine, match_days,  description, remain')
                ->join('teams as teams_p' , 'penalties_officials.team_id','=','teams_p.team_id')
                ->join('matches' , 'penalties_officials.match_id','=','matches.aa_game')
                ->join('teams as teams1' , 'matches.team1','=','teams1.team_id')
                ->join('teams as teams2' , 'matches.team2','=','teams2.team_id')
                ->join('group1' , 'matches.group1','=', 'group1.aa_group')
                ->where('penalties_officials.id','=',$id)
                ->orderby('penalties_officials.infliction_date', 'desc')
                ->get();

        return view('backend.penalty.official.edit', compact('officials'));
    }

    public function show_modal($id)
    {
        $officials= penaltyOfficial::selectRaw('penalties_officials.*, teams_p.onoma_eps as team_name, teams_p.team_id as team_id,   teams1.onoma_eps as onoma_ghp, teams2.onoma_eps as onoma_fil, matches.locked as locked, matches.date_time as date_time, matches.aa_game as match_id, infliction_date, reason, decision_num, fine, match_days,  description, remain')
                ->join('teams as teams_p' , 'penalties_officials.team_id','=','teams_p.team_id')
                ->join('matches' , 'penalties_officials.match_id','=','matches.aa_game')
                ->join('teams as teams1' , 'matches.team1','=','teams1.team_id')
                ->join('teams as teams2' , 'matches.team2','=','teams2.team_id')
                ->join('group1' , 'matches.group1','=', 'group1.aa_group')
                ->where('penalties_officials.id','=',$id)
                ->orderby('penalties_officials.infliction_date', 'desc')
                ->get();

        return view('backend.penalty.official.modal-content', compact('officials'));
    }

     public function insert()
    {
        
        return view('backend.penalty.official.insert');
    }

    public function per_team($id)
    {
        $official_id=$id;
        return view('backend.penalty.official.player', compact('team_id'));
    }

    public function show_per_team($id)
    {
        $official= player::selectRaw('player.*, teams.onoma_web')
                ->join('teams','teams.team_id','=','player.teams_team_id')
                ->where('player.active','=','1')
                ->where('teams_team_id','=',$id)
                ->orderby('player.Surname', 'asc');
        return Datatables::of($official)
        ->addColumn('actions',function($official){
                //return $herbs->getEditButtonAttribute($herbs->id);
                return view('backend.includes.partials.actions',['id'=>$official->player_id, 'condition'=>'activate', 'page'=>'player']);
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
                'name'=> 'required',
                'title'=> 'required',
                'match_id'=> 'required',
                'infliction_date'=>'date_format:"d/m/Y"|required',
                'team'=>'required',
                'fine'=>'numeric|nullable',
                'match_days'=>'numeric|nullable',
            ]);

        $format = 'd/m/Y';

        $date = Carbon::createFromFormat($format, request('infliction_date'));
        $official= penaltyOfficial::findOrFail($id);
        
        $official->name= request('name');
        $official->title= request('title');                        
        $official->team_id= request('team');
        $official->match_id= request('match_id');
        $official->infliction_date= Carbon::parse($date)->format('Y/m/d');
        $official->reason= request('reason');
        $official->decision_num= request('decision_num');
        $official->fine= request('fine');
        $official->match_days= request('match_days');
        $official->kind_of_days= request('kind_of_days');
        $official->description= request('description');
        $official->remain= request('remain');
        $official->save();
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
                'name'=> 'required',
                'title'=> 'required',
                'match_id'=> 'required',
                'infliction_date'=>'date_format:"d/m/Y"|required',
                'team'=>'required',
                'fine'=>'numeric|nullable',
                'match_days'=>'numeric|nullable',

            ]);

        $format = 'd/m/Y';

        $date = Carbon::createFromFormat($format, request('infliction_date'));
        $official= new penaltyOfficial;
                      
        $official->name= request('name');
        $official->title= request('title');                        
        $official->team_id= request('team');
        $official->match_id= request('match_id');
        $official->infliction_date= Carbon::parse($date)->format('Y/m/d');
        $official->reason= request('reason');
        $official->decision_num= request('decision_num');
        $official->fine= request('fine');
        $official->match_days= request('match_days');
        $official->kind_of_days= request('kind_of_days');
        $official->description= request('description');
        $official->remain= request('match_days');
        $official->save();
        /*History Log record*/
        //event(new playerUpdate($official));

        return Redirect::route('admin.penalty.official.index');

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\referees  $referees
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $penaltyOfficial= penaltyOfficial::findOrFail($id)->delete();


       return Redirect::route('admin.penalty.official.index');
    }


}
