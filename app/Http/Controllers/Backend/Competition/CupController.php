<?php

namespace App\Http\Controllers\Backend\Competition;

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

class CupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        
            return view('backend.competition.cup.index');    
        
        
    }
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function deactivated(){
        
            return view('backend.competition.cup.deactivated');    
        
        
    }
         /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function tiebrake($id){
        
            return view('backend.competition.cup.tiebrake', compact('id'));    
        
        
    }
            /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function changeTeams($id){
            $groups=groups::selectRaw('group1.aa_group as id, group1.*, group1.omilos as name, champs.category as category, age_level.Title as ageLevelTitle, season.period as period')
                ->join('champs','champs.champ_id', '=', 'group1.category')
                ->join('age_level','age_level.id', '=', 'group1.age_level')
                ->join('season','season.season_id', '=', 'group1.aa_period')
                ->where('aa_group','=',$id)
                ->get();
            
            return view('backend.competition.cup.changeTeams', compact('groups'));    
        
        
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\referees  $referees
     * @return \Illuminate\Http\Response
     */
        public function edit($id)
    {
         $groups=groups::selectRaw('group1.aa_group as id, group1.*, group1.omilos as name, champs.category as category, age_level.Title as ageLevelTitle, season.period as period')
                ->join('champs','champs.champ_id', '=', 'group1.category')
                ->join('age_level','age_level.id', '=', 'group1.age_level')
                ->join('season','season.season_id', '=', 'group1.aa_period')
                ->where('aa_group','=',$id)
                ->get();

        return view('backend.competition.cup.edit', compact('groups'));
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\referees  $referees
     * @return \Illuminate\Http\Response
     */
        public function draw($id)
    {
         $groups=groups::selectRaw('group1.aa_group as id, group1.*, group1.omilos as name, champs.category as category, age_level.Title as ageLevelTitle, season.period as period')
                ->join('champs','champs.champ_id', '=', 'group1.category')
                ->join('age_level','age_level.id', '=', 'group1.age_level')
                ->join('season','season.season_id', '=', 'group1.aa_period')
                ->where('aa_group','=',$id)
                ->get();
         $teams=teamsPerGroup::selectRaw('teams.onoma_web as teamName, teams.team_id as id')
                            ->join('teams', 'teams.team_id','=','teamspergroup.team')
                            ->where('group','=',$id)
                            ->get();
            foreach($groups as $group)
                $nTeams=$group->omades;
         $anaptixi=anaptixi::selectRaw('anaptixi.*')
                            ->where('n_of_teams','=',$nTeams)
                            ->get();                   
        return view('backend.competition.cup.draw', compact('groups','teams', 'anaptixi'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function regular(){
        $s=season::getRunning()->season_id;
        //$s=$season->getRunning();
        if ($s!=session('season')){
            return redirect()->back()->withFlashDanger('Δεν μπορείτε να δημιουργήσετε ομίλους για την συγκεκριμένη Αγωνιστική Περίοδο');
        }else{
            return view('backend.competition.cup.regular');    
        }
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showPlayOff(){
        $s=season::getRunning()->season_id;
        if ($s!=session('season')){
            return redirect()->back()->withFlashDanger('Δεν μπορείτε να δημιουργήσετε ομίλους για την συγκεκριμένη Αγωνιστική Περίοδο');
        }else{
            return view('backend.competition.cup.playoff');    
        }
        
    }
   
     /**
     * Display the specified resource.
     *
     * @param  \App\referees  $referees
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $cup= groups::selectRaw('group1.aa_group as id, group1.*, group1.omilos as name, champs.category as category, age_level.Title as ageLevelTitle, COUNT(matches.aa_game) as matches, COUNT(NULLIF(score_team_1,"")) as score1, COUNT(NULLIF(score_team_2,"")) as score2, phases.title as phases, champs.flexible as flexible')
                ->join('champs','champs.champ_id', '=', 'group1.category')
                ->join('age_level','age_level.id', '=', 'group1.age_level')
                ->join('phases','phases.id', '=', 'group1.phase')
                ->leftJoin('matches','matches.group1', '=', 'group1.aa_group')
                ->where('group1.aa_period','=',session('season'))
                ->where('group1.category','=',config('default.cup'))
                ->where('group1.active','=','1')
                ->groupBy('group1.aa_group')
                ->orderby('group1.phase', 'desc')->get();
        return Datatables::of($cup)
        ->addColumn('actions',function($cup){
                $delete=true;
                $locked=false;
                 $flexible=false;
                if ($cup->flexible==1)
                    $flexible=true;
                if ($cup->locked==1)
                    $locked=true;
                if ($cup->matches==0){
                    $draw=true;
                    $program=false;
                }else{
                    $draw=false;
                    $program=true;
                }
                if (($cup->score1>0) || ($cup->score1>0))
                    $delete=false;
                return view('backend.competition.partials.cup-actions',['id'=>$cup->id, 'draw'=>$draw, 'delete'=>$delete, 'program'=>$program, 'locked'=>$locked, 'kind'=>$cup->kind ,'flexible'=>$flexible ,'condition'=>'activate']);
        })
        ->rawColumns(['actions'])
        ->make(true);
    } 
     /**
     * Display the specified resource.
     *
     * @param  \App\referees  $referees
     * @return \Illuminate\Http\Response
     */
    public function showDeactivated()
    {
        $cup= groups::selectRaw('group1.aa_group as id, group1.*, group1.omilos as name, champs.category as category, age_level.Title as ageLevelTitle, COUNT(matches.aa_game) as matches, COUNT(NULLIF(score_team_1,"")) as score1, COUNT(NULLIF(score_team_2,"")) as score2, phases.title as phases, champs.flexible as flexible')
                ->join('champs','champs.champ_id', '=', 'group1.category')
                ->join('age_level','age_level.id', '=', 'group1.age_level')
                ->join('phases','phases.id', '=', 'group1.phase')
                ->leftJoin('matches','matches.group1', '=', 'group1.aa_group')
                ->where('group1.aa_period','=',session('season'))
                ->where('group1.category','=',config('default.cup'))
                ->where('group1.active','=','0')
                ->groupBy('group1.aa_group')
                ->orderby('group1.phase', 'desc')->get();
        return Datatables::of($cup)
        ->addColumn('actions',function($cup){
                $delete=true;
                 $locked=false;
                 $flexible=false;
                if ($cup->flexible==1)
                    $flexible=true;
                if ($cup->locked==1)
                    $locked=true;
                if ($cup->matches==0){
                    $draw=true;
                    $program=false;
                }else{
                    $draw=false;
                    $program=true;
                }
                if (($cup->score1>0) || ($cup->score1>0))
                    $delete=false;
                return view('backend.competition.partials.cup-actions',['id'=>$cup->id, 'draw'=>$draw, 'delete'=>$delete, 'program'=>$program, 'locked'=>$locked, 'kind'=>$cup->kind, 'flexible'=>$flexible , 'condition'=>'deactivate']);
        })
        ->rawColumns(['actions'])
        ->make(true);
    } 
        public function show_modal($id)
    {
        $groups=groups::selectRaw('group1.aa_group as id, group1.*, group1.omilos as name, champs.category as category, age_level.Title as ageLevelTitle, season.period as period, phases.title as phases')
                ->join('champs','champs.champ_id', '=', 'group1.category')
                ->join('age_level','age_level.id', '=', 'group1.age_level')
                ->join('phases','phases.id', '=', 'group1.phase')
                ->join('season','season.season_id', '=', 'group1.aa_period')
                ->where('aa_group','=',$id)
                ->get();
        $teams=teamsPerGroup::selectRaw('distinct(teams.onoma_web) as teamName, draws.key as drawKey')
                            ->join('teams', 'teams.team_id','=','teamspergroup.team')
                            ->leftJoin('draws', function($join)
                         {
                             $join->on('draws.team', '=', 'teamspergroup.team');
                             $join->on('draws.group', '=', 'teamspergroup.group');
                         })
                            ->where('teamspergroup.group','=',$id)
                            ->get();
        return view('backend.competition.partials.modal-content-cup', compact('groups','teams'));
    }

  

    /**
     * Saves the new group and the teams that compete on this.
     *
     * @param  \App\program  $program
     * @return \Illuminate\Http\Response
     */
    public function saveGroup()
    {
        $this->validate(request(), [
                'nTeams'=> 'required|numeric',
                'groupName'=>'required',
                'qualify'=>'numeric|nullable',
                'teams'=>'required|min:'.Input::get('nTeams').'|max:'.Input::get('nTeams')
            ]);
        $champ=champs::findOrFail(config('default.cup'));
        $teams = Input::get('teams');
        $group=new groups;
        $group->aa_period=session('season');
        $group->omilos=Input::get('groupName');
        $group->category=config('default.cup');
        $group->omades=Input::get('nTeams');
        $group->title=$champ->category.'-'.Input::get('groupName');
        $group->age_level=$champ->age_level;
        $group->logo=$champ->logo;
        $group->phase=Input::get('phases');
        $group->qualify=Input::get('qualify');
        $group->kind=1;
        $group->regular_season=1;
        $group->save();
        $lastInsertId=$group->aa_group;
        foreach ($teams as $team){
            $tpg=new teamsPerGroup;
            $tpg->group=$lastInsertId;
            $tpg->team=$team;
            $tpg->weight=0;
            $tpg->points=0;
            $tpg->save();
        }

       return Redirect::route('admin.competition.cup.index')->withFlashSuccess('Επιτυχής Αποθήκευση');
   
    }

    public function activate($id)
    {
         $groups= groups::findOrFail($id);               
         $groups->active= 1;
         $groups->save();

         return Redirect::route('admin.competition.cup.index');
    }

    public function deactivate($id)
    {
        $groups= groups::findOrFail($id);               
         $groups->active= 0;
         $groups->save();

         return Redirect::route('admin.competition.cup.deactivated');
    }

    public function savePlayOffGroup()
    {
        $this->validate(request(), [
                'nTeams'=> 'required|numeric',
                'groupName'=>'required',
                'qualify'=>'numeric|nullable',
                'phases'=>'required',
                'team_id'=>'required|min:'.Input::get('nTeams').'|max:'.Input::get('nTeams'),
                'points'=>'min:0',
            ]);
        $champ=champs::findOrFail(config('default.cup'));
        $teams = Input::get('team_id');
        $points = Input::get('points');
        $points_arr= Array();
        
        foreach ($points as $key => $value) {
            $points_arr[$key]=$value;
        }
        $group=new groups;
        $group->aa_period=session('season');
        $group->omilos=Input::get('groupName');
        $group->category=config('default.cup');
        $group->omades=Input::get('nTeams');
        $group->title=$champ->category.'-'.Input::get('groupName');
        $group->age_level=$champ->age_level;
        $group->logo=$champ->logo;
        $group->phase=Input::get('phases');
        $group->qualify=Input::get('qualify');
        $group->kind=1;
        $group->regular_season=1;
        $group->save();
        $lastInsertId=$group->aa_group;
        foreach ($teams as $key=>$team){
            $tpg=new teamsPerGroup;
            $tpg->group=$lastInsertId;
            $tpg->team=$team;
            $tpg->weight=0;
            $tpg->points=$points_arr[$key];
            $tpg->save();
        }

       return Redirect::route('admin.competition.cup.index')->withFlashSuccess('Επιτυχής Αποθήκευση');
   
    }
        /**
     * Saves the new group and the teams that compete on this.
     *
     * @param  \App\program  $program
     * @return \Illuminate\Http\Response
     */
    public function saveMatches(Request $request, $id)
    {
        $groups=groups::selectRaw('group1.aa_group as id, group1.*')
                ->where('aa_group','=',$id)
                ->get();
        foreach($groups as $group)
            $omades=$group->omades;

        if ($request->rounds==2)
            $round=1;
        elseif ($request->rounds==3) {
            $round=2;
        }else{
            $round=0;
        }
        if ($round==0)
            $anaptixi=anaptixi::selectRaw('anaptixi.*')
                            ->where('n_of_teams','=',$omades)
                            ->get();
        else
            $anaptixi=anaptixi::selectRaw('anaptixi.*')
                            ->where('n_of_teams','=',$omades)
                            ->where('round','=',$round)
                            ->get();
        if (request('fields'))
            $fields= true;
        else
            $fields= false;
        $teams= Array();
        
        foreach ($request->team as $key => $value) {
            $teams[$value]=$key;
            $draw= new draws;
            $draw->group=$id;
            $draw->team=$key;
            $draw->key=$value;
            $draw->save();
        }
        
        
        foreach($anaptixi as $an){
            $home=$teams[$an->home];
            $away=$teams[$an->away];
            $matches=new matches;
            $matches->group1=$id;
            $matches->date_time=Carbon::parse(config('default.datetime'))->format('Y/m/d H:i');;
            $matches->round=$an->round;
            $matches->match_day=$an->match_days;
            if ($fields){   
                 $team=new team;
                 $court=$team->getCourt($home);
                 if ($court==0)
                    $court=config('default.court');
            }else{
                $court=config('default.court');
             }
            $matches->court=$court;
            $matches->team1=$home;
            $matches->team2=$away;
            $matches->save();
        }   

        return Redirect::route('admin.competition.cup.index')->withFlashSuccess('Επιτυχής Αποθήκευση');
       
   
    }
     /**
     * Display cup matches insert page.
     *
     * @return \Illuminate\Http\Response
     */
    public function cupMatches(){
            
            return view('backend.competition.cup.cup');    
        
        
    }
    /**
     * Display inputs that cup matches filled in.
     *
     * @return \Illuminate\Http\Response
     */
    public function cupInputs(){
            $nTeams=Input::get('nTeams');
            return view('backend.competition.partials.cupInputs', compact('nTeams'));    
        
        
    }
         /**
     * Saves the matchesof in cup format.
     *
     * @param  \App\program  $program
     * @return \Illuminate\Http\Response
     */
    public function saveCupMatches(Request $request, $id)
    {   
         $this->validate(request(), [
                'nTeams'=> 'required|numeric',
                'groupName'=>'required',
                'round'=>'required|numeric',
                'phases'=>'required',
                'teamID1'=>'required|min:'.Input::get('nTeams').'|max:'.Input::get('nTeams'),
                'teamID2'=>'required|min:'.Input::get('nTeams').'|max:'.Input::get('nTeams')
            ]);
        $champ=champs::findOrFail(config('default.cup'));
        $group=new groups;
        $group->aa_period=session('season');
        $group->omilos=Input::get('groupName');
        $group->category=config('default.cup');
        $group->omades=Input::get('nTeams');
        $group->title=$champ->category.'-'.Input::get('groupName');
        $group->age_level=$champ->age_level;
        $group->logo=$champ->logo;
        $group->phase=Input::get('phases');
        $group->kind=2;
        $group->regular_season=1;
        $group->save();
        $lastInsertId=$group->aa_group;

        if (request('double'))
            $double= true;
        else
            $double= false;

        if (request('fields'))
            $fields= true;
        else
            $fields= false;
        $team1= Array();
        $team2= Array();
        
        foreach ($request->teamID1 as $key => $value) {
            $team1[$key]=$value;
            $teamsPerGroup= new teamsPerGroup;
            $teamsPerGroup->group=$lastInsertId;
            $teamsPerGroup->team=$value;
            $teamsPerGroup->weight=0;
            $teamsPerGroup->points=0;
            $teamsPerGroup->save();
        }
        foreach ($request->teamID2 as $key => $value) {
            $team2[$key]=$value;
            $teamsPerGroup= new teamsPerGroup;
            $teamsPerGroup->group=$lastInsertId;
            $teamsPerGroup->team=$value;
            $teamsPerGroup->weight=0;
            $teamsPerGroup->points=0;
            $teamsPerGroup->save();
        }
        
        
       foreach ($request->teamID1 as $key => $value) {
            $home=$team1[$key];
            $away=$team2[$key];
            $matches=new matches;
            $matches->group1=$lastInsertId;
            $matches->date_time=Carbon::parse(config('default.datetime'))->format('Y/m/d H:i');;
            $matches->round=Input::get('round');
            $matches->match_day=1;
            if ($fields){   
                 $team=new team;
                 $court=$team->getCourt($home);
                 if ($court==0)
                    $court=config('default.court');
            }else{
                $court=config('default.court');
             }
            $matches->court=$court;
            $matches->team1=$home;
            $matches->team2=$away;
            $matches->save();
        }   
        if ($double){
            foreach ($request->teamID1 as $key => $value) {
                $home=$team2[$key];
                $away=$team1[$key];
                $matches=new matches;
                $matches->group1=$lastInsertId;
                $matches->date_time=Carbon::parse(config('default.datetime'))->format('Y/m/d H:i');;
                $matches->round=Input::get('round');
                $matches->match_day=2;
                if ($fields){   
                     $team=new team;
                     $court=$team->getCourt($home);
                     if ($court==0)
                        $court=config('default.court');
                }else{
                    $court=config('default.court');
                 }
                $matches->court=$court;
                $matches->team1=$home;
                $matches->team2=$away;
                $matches->save();
            } 
        }
        return Redirect::route('admin.competition.cup.index')->withFlashSuccess('Επιτυχής Αποθήκευση');
       
   
    }
    /**
     * Saves the new group and the teams that compete on this.
     *
     * @param  \App\program  $program
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $this->validate(request(), [
                'omilos'=>'required',
                'title'=>'required',
                'logo' => 'file|image|mimes:jpeg,png,gif|max:2048',
                'phases'=>'required',
                'qualify'=>'numeric|nullable',
            ]);

        $group=groups::findOrFail($id);
        if ($request->hasFile('logo')){
             $photoName = time().'.'.$request->logo->getClientOriginalExtension(); 
             $t = Storage::put('logos/'.$photoName, file_get_contents($request->file('logo')), 'public');    
             $group->logo=url('logos/'.$photoName);
         } 
        $group->omilos=Input::get('omilos');
        $group->title=Input::get('title');
        $group->qualify=Input::get('qualify');
        $group->phase=Input::get('phases');
        $group->save();
        

       return redirect()->back()->withFlashSuccess('Επιτυχής Αποθήκευση');
   
    }
     /*Saves the groups teams after changing*/
    public function saveTeams(Request $request, $id){
            foreach ($request->teams as $key=>$val){
                if ($key!=$val){
                    $tpg=teamsPerGroup::where('team','=',$key)
                                      ->where('group','=',$id)
                                      ->update(['team'=>$val]);
                    $matches=matches::where('team1','=', $key)
                                        ->where('group1','=',$id)
                                        ->update(['team1'=>$val]);
                    $matches=matches::where('team2','=', $key)
                                        ->where('group1','=',$id)
                                        ->update(['team2'=>$val]);
                }
            }
        return redirect()->back()->withFlashSuccess('Επιτυχής Αποθήκευση');
    }
/*  Redirect to the program of the group*/
    public function program($id){
            $matches=matches::selectRaw('match_day')
                             ->where('matches.group1','=',$id)
                             ->where('matches.date_time','>=',Carbon::parse(Carbon::now())->format('Y/m/d H:s:i')) 
                             ->orderby('matches.date_time', 'asc')
                             ->limit(1)
                             ->get();
            if ($matches->isEmpty()){
                $md_from=1;
                $md_to=30;
            }else{
                foreach ($matches as $match) {
                $md_from=$match->match_day;
                $md_to=$match->match_day;
            }
            }
            
            session()->put('category', $id);
            session()->put('md_from', $md_from);
            session()->put('md_to', $md_to);
            return Redirect::route('admin.program.program.index');   
        
        
    }
   /*  Delete group and all raws that affects*/
    public function delete($id)
        {
           $teamsPerGroup=teamsPerGroup::where('group','=',$id)->delete();
           $draw=draws::where('group','=',$id)->delete();
           $matches=matches::where('group1','=',$id)->delete();
           $groups= groups::findOrFail($id)->delete();


           return Redirect::route('admin.competition.cup.index');
        }

}
