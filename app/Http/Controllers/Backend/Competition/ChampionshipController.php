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

class ChampionshipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        
            return view('backend.competition.championship.index');    
        
        
    }
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function deactivated(){
        
            return view('backend.competition.championship.deactivated');    
        
        
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
            
            return view('backend.competition.championship.changeTeams', compact('groups'));    
        
        
    }
         /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function tiebrake($id){
        
            return view('backend.competition.championship.tieBrake', compact('id'));    
        
        
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

        return view('backend.competition.championship.edit', compact('groups'));
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
        return view('backend.competition.championship.draw', compact('groups','teams', 'anaptixi'));
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
            return view('backend.competition.championship.regular');    
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
            return view('backend.competition.championship.playoff');    
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
        $championships= groups::selectRaw('group1.aa_group as id, group1.*, group1.omilos as name, champs.category as category, age_level.Title as ageLevelTitle, COUNT(matches.aa_game) as matches, COUNT(NULLIF(score_team_1,"")) as score1, COUNT(NULLIF(score_team_2,"")) as score2, champs.flexible as flexible')
                ->join('champs','champs.champ_id', '=', 'group1.category')
                ->join('age_level','age_level.id', '=', 'group1.age_level')
                ->leftJoin('matches','matches.group1', '=', 'group1.aa_group')
                ->where('group1.aa_period','=',session('season'))
                ->where('group1.category','<>',config('default.cup'))
                ->where('group1.active','=','1')
                ->groupBy('group1.aa_group')
                ->orderby('group1.category', 'asc')->get();
        return Datatables::of($championships)
        ->addColumn('actions',function($championships){
                $delete=true;
                $locked=false;
                $flexible=false;
                if ($championships->flexible==1)
                    $flexible=true;
                if ($championships->locked==1)
                    $locked=true;
                if ($championships->matches==0){
                    $draw=true;
                    $program=false;
                }else{
                    $draw=false;
                    $program=true;
                }
                if (($championships->score1>0) || ($championships->score1>0))
                    $delete=false;
                return view('backend.competition.partials.actions',['id'=>$championships->id, 'draw'=>$draw, 'delete'=>$delete, 'program'=>$program, 'locked'=>$locked, 'kind'=>$championships->kind, 'flexible'=>$flexible,'condition'=>'activate']);
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
        $championships= groups::selectRaw('group1.aa_group as id, group1.*, group1.omilos as name, champs.category as category, age_level.Title as ageLevelTitle, COUNT(matches.aa_game) as matches, COUNT(NULLIF(score_team_1,"")) as score1, COUNT(NULLIF(score_team_2,"")) as score2, champs.flexible as flexible')
                ->join('champs','champs.champ_id', '=', 'group1.category')
                ->join('age_level','age_level.id', '=', 'group1.age_level')
                ->leftJoin('matches','matches.group1', '=', 'group1.aa_group')
                ->where('group1.aa_period','=',session('season'))
                ->where('kind','=','1')
                ->where('group1.active','=','0')
                ->groupBy('group1.aa_group')
                ->orderby('group1.category', 'asc')->get();
        return Datatables::of($championships)
        ->addColumn('actions',function($championships){
                $delete=true;
                $locked=false;
                 $flexible=false;
                if ($championships->flexible==1)
                    $flexible=true;
                if ($championships->locked==1)
                    $locked=true;
                if ($championships->matches==0){
                    $draw=true;
                    $program=false;
                }else{
                    $draw=false;
                    $program=true;
                }
                if (($championships->score1>0) || ($championships->score1>0))
                    $delete=false;
                return view('backend.competition.partials.actions',['id'=>$championships->id, 'draw'=>$draw, 'delete'=>$delete, 'program'=>$program,  'locked'=>$locked, 'kind'=>$championships->kind, 'flexible'=>$flexible,'condition'=>'deactivate']);
        })
        ->rawColumns(['actions'])
        ->make(true);
    } 
        public function show_modal($id)
    {
        $groups=groups::selectRaw('group1.aa_group as id, group1.*, group1.omilos as name, champs.category as category, age_level.Title as ageLevelTitle, season.period as period')
                ->join('champs','champs.champ_id', '=', 'group1.category')
                ->join('age_level','age_level.id', '=', 'group1.age_level')
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
        return view('backend.competition.partials.modal-content', compact('groups','teams'));
    }

    /**
     * Check Court indegrity.
     *
     * @param  \App\referees  $referees
     * @return \Illuminate\Http\Response
     */


     public function rating($id)
    {
               
        // $rating=DB::select("SELECT team_id, w, tpgID as id, onoma, emblem, vathmoi_fil, vathmoi_gip, (-IFNULL(vathmoi_poin_gip,0)- IFNULL(vathmoi_poin_fil,0)) as vathmoi_poin_syn,
        //     (IFNULL(vathmoi_fil,0) + IFNULL(vathmoi_gip,0) + IFNULL(extraP,0) - IFNULL(vathmoi_poin_gip,0)- IFNULL(vathmoi_poin_fil,0)) as syn_vathm, goal_yper_gip, goal_yper_fil, (goal_yper_gip + goal_yper_fil) as goal_yper_syn,
        //     goal_kata_gip, goal_kata_fil, (goal_kata_gip + goal_kata_fil) as goal_kata_syn, nikes_gip, isopalies_gip, nikes_fil, isopalies_fil,
        //     (nikes_gip+nikes_fil) as nikes_syn, (isopalies_gip+isopalies_fil) as isopalies_syn, syn_match_gip, syn_match_fil
        //     from
        //                             (SELECT teams.team_id, teams.onoma_eps,  teamspergroup.team,  SUM( matches.points1 ) AS vathmoi_gip,
        //                             SUM( penalties_teams.pointsoff) AS vathmoi_poin_gip, SUM( CAST( matches.score_team_1 AS UNSIGNED ) ) AS goal_yper_gip,
        //                             SUM( CAST( matches.score_team_2 AS UNSIGNED ) ) AS goal_kata_gip, COUNT( IF( matches.points1 = 3, 1, NULL ) ) AS nikes_gip,
        //             COUNT( IF( matches.points1 = 1, 1, NULL ) ) AS isopalies_gip, 
        //                             COUNT(IF(matches.points1 + matches.points2 > 0, 1, NULL)) as syn_match_gip, teamspergroup.weight as w, teamspergroup.id as tpgID , teamspergroup.startPoints as extraP 
        //                             FROM matches left join penalties_teams on (penalties_teams.team_id= matches.team1
        //                             AND penalties_teams.match_id= matches.aa_game and penalties_teams.pointsoff<>'0')
        //                             inner join teamspergroup on teamspergroup.group= matches.group1
        //                             inner join teams  on teams.team_id = teamspergroup.team 
        //                             WHERE matches.team1 = teams.team_id  and
        //                             matches.group1 =  '".$id."'
        //                             GROUP BY teams.team_id
        //                             ORDER BY teams.team_id desc) T1
        //                             INNER JOIN
        //                             (SELECT teams.team_id as team_id, teams.onoma_web as onoma, teams.emblem as emblem, teamspergroup.team, SUM( matches.points2 ) AS vathmoi_fil,
        //             SUM( penalties_teams.pointsoff ) AS vathmoi_poin_fil,
        //                             SUM( CAST( matches.score_team_2 AS UNSIGNED ) ) AS goal_yper_fil, SUM( CAST( matches.score_team_1 AS UNSIGNED ) ) AS goal_kata_fil,
        //             COUNT( IF( matches.points2 =3, 1, NULL ) ) AS nikes_fil, COUNT( IF( matches.points2 =1, 1, NULL ) ) AS isopalies_fil,
        //                             COUNT(IF(matches.points1 + matches.points2 > 0, 1, NULL)) as syn_match_fil
        //                             FROM matches left join penalties_teams on (penalties_teams.team_id= matches.team2
        //                             AND penalties_teams.match_id= matches.aa_game and penalties_teams.pointsoff<>'0') 
        //                             inner join teamspergroup on teamspergroup.group= matches.group1
        //                             inner join teams  on teams.team_id = teamspergroup.team 
        //                             WHERE 
        //                             matches.team2 = teams.team_id  and
        //                             matches.group1 =  '".$id."'
                                    
        //                             GROUP BY teams.team_id
        //                             ORDER BY teams.team_id DESC) T2
        //                              USING (team_id)
        //                             ORDER BY syn_vathm desc, w asc, (goal_yper_syn- goal_kata_syn) desc, onoma asc");
        $ranking=teamsPerGroup::selectRaw('teamspergroup.*, teams.onoma_web as onoma, teams.emblem as emblem, IFNULL(points,0)- IFNULL(poines,0) as points_syn')
                                ->join('teams','teams.team_id','=','teamspergroup.team')
                                ->where('group','=', $id)
                                ->orderBy('points_syn', 'desc')
                                ->orderBy('weight', 'asc')
                                ->orderBy('onoma', 'asc');
        return Datatables::of($ranking)
        ->addIndexColumn()
        ->addColumn('actions',function($ranking){
                //return $herbs->getEditButtonAttribute($herbs->id);
                return view('backend.competition.partials.tieBrakeActions',['id'=>$ranking->id]);
        })
        ->addColumn('syn_vathm', function($ranking){
                return intval($ranking->points)-intval($ranking->poines);
            })
        ->addColumn('syn_match', function($ranking){
                return intval($ranking->match_home)+intval($ranking->match_away);
            })
       ->addColumn('goal_difference', function($ranking){
                return (intval($ranking->goalHomePlus)+intval($ranking->goalAwayPlus))-(intval($ranking->goalHomeMinus)+intval($ranking->goalAwayMinus));
            })
        ->rawColumns(['actions'])
        ->make(true);
    }

    public function addW($id)
    {
         $teamsPerGroup= teamsPerGroup::findOrFail($id); 
         if ($teamsPerGroup->weight>0)              
         $teamsPerGroup->weight= intval($teamsPerGroup->weight) - 1;
         $teamsPerGroup->save();

         return Redirect::route('admin.competition.championship.rating',$teamsPerGroup->group);
    }

    public function subW($id)
    {
         $teamsPerGroup= teamsPerGroup::findOrFail($id);             
         $teamsPerGroup->weight= intval($teamsPerGroup->weight) + 1;
         $teamsPerGroup->save();

         return Redirect::route('admin.competition.championship.rating',$teamsPerGroup->group);
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
                'category'=> 'required',
                'nTeams'=> 'required|numeric',
                'groupName'=>'required',
                'qualify'=>'numeric|nullable',
                'relegation'=>'numeric|nullable',
                'q_mparaz'=>'numeric|nullable',
                'r_mparaz'=>'numeric|nullable',
                'teams'=>'required|min:'.Input::get('nTeams').'|max:'.Input::get('nTeams')
            ]);
        $champ=champs::findOrFail(Input::get('category'));
        $teams = Input::get('teams');
        $group=new groups;
        $group->aa_period=session('season');
        $group->omilos=Input::get('groupName');
        $group->category=Input::get('category');
        $group->omades=Input::get('nTeams');
        $group->title=$champ->category.'-'.Input::get('groupName');
        $group->age_level=$champ->age_level;
        $group->logo=$champ->logo;
        $group->qualify=Input::get('qualify');
        $group->relegation=Input::get('relegation');
        $group->q_mparaz=Input::get('q_mparaz');
        $group->r_mparaz=Input::get('r_mparaz');
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

       return Redirect::route('admin.competition.championship.index')->withFlashSuccess('Επιτυχής Αποθήκευση');
   
    }

    public function activate($id)
    {
         $groups= groups::findOrFail($id);               
         $groups->active= 1;
         $groups->save();

         return Redirect::route('admin.competition.championship.index');
    }

    public function deactivate($id)
    {
        $groups= groups::findOrFail($id);               
         $groups->active= 0;
         $groups->save();

         return Redirect::route('admin.competition.championship.deactivated');
    }

    public function savePlayOffGroup()
    {
        $this->validate(request(), [
                'category'=> 'required',
                'nTeams'=> 'required|numeric',
                'groupName'=>'required',
                'qualify'=>'numeric|nullable',
                'relegation'=>'numeric|nullable',
                'q_mparaz'=>'numeric|nullable',
                'r_mparaz'=>'numeric|nullable',
                'team_id'=>'required|min:'.Input::get('nTeams').'|max:'.Input::get('nTeams'),
                'points'=>'min:0',
            ]);
        $champ=champs::findOrFail(Input::get('category'));
        $teams = Input::get('team_id');
        $points = Input::get('points');
        $points_arr= Array();
        
        foreach ($points as $key => $value) {
            $points_arr[$key]=$value;
        }
        $group=new groups;
        $group->aa_period=session('season');
        $group->omilos=Input::get('groupName');
        $group->category=Input::get('category');
        $group->omades=Input::get('nTeams');
        $group->title=$champ->category.'-'.Input::get('groupName');
        $group->age_level=$champ->age_level;
        $group->logo=$champ->logo;
        $group->qualify=Input::get('qualify');
        $group->relegation=Input::get('relegation');
        $group->q_mparaz=Input::get('q_mparaz');
        $group->r_mparaz=Input::get('r_mparaz');
        $group->kind=1;
        $group->regular_season=0;
        $group->save();
        $lastInsertId=$group->aa_group;
        foreach ($teams as $key=>$team){
            $tpg=new teamsPerGroup;
            $tpg->group=$lastInsertId;
            $tpg->team=$team;
            $tpg->weight=0;
            $tpg->points = $points_arr[$key];
            $tpg->startPoints = $points_arr[$key];
            $tpg->save();
        }

       return Redirect::route('admin.competition.championship.index')->withFlashSuccess('Επιτυχής Αποθήκευση');
   
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
        }elseif ($request->rounds==4) {
            $round=4;
        }
        else{
            $round=0;
        }
        if ($round==0 || $round==4)
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
        
        $md=0;
        foreach($anaptixi as $an){
            try {
                $home=$teams[$an->home];
            } catch (\Exception $e) {
                $home=0;
            }
            try {
                $away=$teams[$an->away];
            } catch (\Exception $e) {
                $away=0;
            }
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
            $md=$an->match_days;
        }   
        if ($round==4){
            foreach($anaptixi as $an){
                try {
                    $home=$teams[$an->home];
                } catch (\Exception $e) {
                    $home=0;
                }
                try {
                    $away=$teams[$an->away];
                } catch (\Exception $e) {
                    $away=0;
                }
                $matches=new matches;
                $matches->group1=$id;
                $matches->date_time=Carbon::parse(config('default.datetime'))->format('Y/m/d H:i');;
                $matches->round=intval($an->round)+2;
                $matches->match_day=intval($an->match_days)+intval($md);
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

        return Redirect::route('admin.competition.championship.index')->withFlashSuccess('Επιτυχής Αποθήκευση');
       
   
    }
     /**
     * Display cup matches insert page.
     *
     * @return \Illuminate\Http\Response
     */
    public function friendly(){
            
            return view('backend.competition.championship.friendly');    
        
        
    }

         /**
     * Saves the matchesof in cup format.
     *
     * @param  \App\program  $program
     * @return \Illuminate\Http\Response
     */
    public function saveFriendlyMatches(Request $request, $id)
    {   
         $this->validate(request(), [
                'category'=>'required',
                'nTeams'=> 'required|numeric',
                'teamID1'=>'required|min:'.Input::get('nTeams').'|max:'.Input::get('nTeams'),
                'teamID2'=>'required|min:'.Input::get('nTeams').'|max:'.Input::get('nTeams')
            ]);
        $groups=groups::findOrFail(Input::get('category'));
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
           
        }
        foreach ($request->teamID2 as $key => $value) {
            $team2[$key]=$value;
           
        }
        
        
       foreach ($request->teamID1 as $key => $value) {
            $home=$team1[$key];
            $away=$team2[$key];
            $matches=new matches;
            $matches->group1=Input::get('category');
            $matches->date_time=Carbon::parse(config('default.datetime'))->format('Y/m/d H:i');;
            if ($fields){   
                 $team=new team;
                 $court=$team->getCourt($home);
                 if ($court==0)
                    $court=config('default.court');
            }else{
                $court=config('default.court');
             }
            $matches->round=1;
            $matches->match_day=1;
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
                $matches->group1=Input::get('category');
                $matches->date_time=Carbon::parse(config('default.datetime'))->format('Y/m/d H:i');;
                if ($fields){   
                     $team=new team;
                     $court=$team->getCourt($home);
                     if ($court==0)
                    $court=config('default.court');
                }else{
                    $court=config('default.court');
                 }
                $matches->round=1;
                $matches->match_day=1;
                $matches->court=$court;
                $matches->team1=$home;
                $matches->team2=$away;
                $matches->save();
            } 
        }
        return Redirect::route('admin.competition.championship.index')->withFlashSuccess('Επιτυχής Αποθήκευση');
       
   
    }
     /**
     * Display cup matches insert page.
     *
     * @return \Illuminate\Http\Response
     */
    public function cupMatches(){
            
            return view('backend.competition.championship.cup');    
        
        
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
                'category'=>'required',
                'nTeams'=> 'required|numeric',
                'groupName'=>'required',
                'phases'=>'required',
                'teamID1'=>'required|min:'.Input::get('nTeams').'|max:'.Input::get('nTeams'),
                'teamID2'=>'required|min:'.Input::get('nTeams').'|max:'.Input::get('nTeams')
            ]);
        $champ=champs::findOrFail(Input::get('category'));
        $group=new groups;
        $group->aa_period=session('season');
        $group->omilos=Input::get('groupName');
        $group->category=Input::get('category');
        $group->omades=Input::get('nTeams');
        $group->title=$champ->category.'-'.Input::get('groupName');
        $group->age_level=$champ->age_level;
        $group->logo=$champ->logo;
        $group->phase=Input::get('phases');
        $group->kind=2;
        $group->regular_season=0;
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
            $matches->round=1;
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
                $matches->round=2;
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
        return Redirect::route('admin.competition.championship.index')->withFlashSuccess('Επιτυχής Αποθήκευση');
       
   
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
                'qualify'=>'numeric|nullable',
                'relegation'=>'numeric|nullable',
                'q_mparaz'=>'numeric|nullable',
                'r_mparaz'=>'numeric|nullable',
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
        $group->relegation=Input::get('relegation');
        $group->q_mparaz=Input::get('q_mparaz');
        $group->r_mparaz=Input::get('r_mparaz');
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


           return Redirect::route('admin.competition.championship.index');
        }

    /*ranking update to the teams_per_group */
    public function updateRanking($id)
        {
               
        $rating=DB::select("SELECT team_id, w, tpgID as id, onoma, emblem, vathmoi_fil, vathmoi_gip, (IFNULL(vathmoi_poin_gip,0)+ IFNULL(vathmoi_poin_fil,0)) as vathmoi_poin_syn,
            (IFNULL(vathmoi_fil,0) + IFNULL(vathmoi_gip,0) + IFNULL(extraP,0) - IFNULL(vathmoi_poin_gip,0)- IFNULL(vathmoi_poin_fil,0)) as syn_vathm, goal_yper_gip, goal_yper_fil, (goal_yper_gip + goal_yper_fil) as goal_yper_syn,
            goal_kata_gip, goal_kata_fil, (goal_kata_gip + goal_kata_fil) as goal_kata_syn, nikes_gip, isopalies_gip, nikes_fil, isopalies_fil,
            (nikes_gip+nikes_fil) as nikes_syn, (isopalies_gip+isopalies_fil) as isopalies_syn, syn_match_gip, syn_match_fil
            from
                                    (SELECT teams.team_id, teams.onoma_eps,  teamspergroup.team,  SUM( matches.points1 ) AS vathmoi_gip,
                                    SUM( penalties_teams.pointsoff) AS vathmoi_poin_gip, SUM( CAST( matches.score_team_1 AS UNSIGNED ) ) AS goal_yper_gip,
                                    SUM( CAST( matches.score_team_2 AS UNSIGNED ) ) AS goal_kata_gip, COUNT( IF( matches.points1 = 3, 1, NULL ) ) AS nikes_gip,
                    COUNT( IF( matches.points1 = 1, 1, NULL ) ) AS isopalies_gip, 
                                    COUNT(IF(matches.points1 + matches.points2 > 0, 1, NULL)) as syn_match_gip, teamspergroup.weight as w, teamspergroup.id as tpgID , teamspergroup.startPoints as extraP 
                                    FROM matches left join penalties_teams on (penalties_teams.team_id= matches.team1
                                    AND penalties_teams.match_id= matches.aa_game and penalties_teams.pointsoff<>'0')
                                    inner join teamspergroup on teamspergroup.group= matches.group1
                                    inner join teams  on teams.team_id = teamspergroup.team 
                                    WHERE matches.team1 = teams.team_id  and
                                    matches.group1 =  '".$id."'
                                    GROUP BY teams.team_id
                                    ORDER BY teams.team_id desc) T1
                                    INNER JOIN
                                    (SELECT teams.team_id as team_id, teams.onoma_web as onoma, teams.emblem as emblem, teamspergroup.team, SUM( matches.points2 ) AS vathmoi_fil,
                    SUM( penalties_teams.pointsoff ) AS vathmoi_poin_fil,
                                    SUM( CAST( matches.score_team_2 AS UNSIGNED ) ) AS goal_yper_fil, SUM( CAST( matches.score_team_1 AS UNSIGNED ) ) AS goal_kata_fil,
                    COUNT( IF( matches.points2 =3, 1, NULL ) ) AS nikes_fil, COUNT( IF( matches.points2 =1, 1, NULL ) ) AS isopalies_fil,
                                    COUNT(IF(matches.points1 + matches.points2 > 0, 1, NULL)) as syn_match_fil
                                    FROM matches left join penalties_teams on (penalties_teams.team_id= matches.team2
                                    AND penalties_teams.match_id= matches.aa_game and penalties_teams.pointsoff<>'0') 
                                    inner join teamspergroup on teamspergroup.group= matches.group1
                                    inner join teams  on teams.team_id = teamspergroup.team 
                                    WHERE 
                                    matches.team2 = teams.team_id  and
                                    matches.group1 =  '".$id."'
                                    
                                    GROUP BY teams.team_id
                                    ORDER BY teams.team_id DESC) T2
                                     USING (team_id)
                                    ORDER BY syn_vathm desc, w asc, (goal_yper_syn- goal_kata_syn) desc, onoma asc");
        foreach($rating as $rat){
            $tPG=teamsPerGroup::where('team','=',$rat->team_id)->where('group','=',$id)->first();
            $tPG->points= $rat->syn_vathm;
            $tPG->poines= $rat->vathmoi_poin_syn;
            $tPG->match_home=$rat->syn_match_gip;
            $tPG->match_away=$rat->syn_match_fil;
            $tPG->goalHomePlus=$rat->goal_yper_gip;
            $tPG->goalHomeMinus=$rat->goal_kata_gip;
            $tPG->goalAwayPlus=$rat->goal_yper_fil;
            $tPG->goalAwayMinus=$rat->goal_kata_fil;
            $tPG->wins_home=$rat->nikes_gip;
            $tPG->draws_home=$rat->isopalies_gip;
            $tPG->defeat_home=intval($rat->syn_match_gip)- intval($rat->nikes_gip)- intval($rat->isopalies_gip);
            $tPG->wins_away=$rat->nikes_fil;
            $tPG->draws_away=$rat->isopalies_fil;
            $tPG->defeat_away=intval($rat->syn_match_fil)- intval($rat->nikes_fil)- intval($rat->isopalies_fil);
            $tPG->save();
        }
         return redirect()->back()->withFlashSuccess('Επιτυχής Ενημέρωση');
    }    

    public function rankingJson($category){
        $ranking=teamsPerGroup::selectRaw('teamspergroup.*, teams.onoma_web as onoma, teams.emblem as emblem, IFNULL(points,0)- IFNULL(poines,0) as points_syn')
                                ->join('teams','teams.team_id','=','teamspergroup.team')
                                ->where('group','=', $id)
                                ->orderBy('points_syn', 'desc')
                                ->orderBy('weight', 'asc')
                                ->orderBy('onoma', 'asc')
                                ->get();
        $content=json_decode($ranking);
        return response()->json($content);
    }
}
