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
use App\Models\Backend\referees;
use App\Models\Backend\observer;
use App\Models\Backend\RefereeNotification;
use App\Models\Backend\teamsPerGroup;
use App\Models\Backend\penaltyOfficial;
use App\Models\Backend\penaltyPlayer;
use App\Models\Backend\penaltyTeam;
use Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;

class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return view('backend.program.program.index');
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function per_date(){
        return view('backend.program.program.date');
    }

    public function openCourtCheck(){
        return view('backend.program.program.courtCheck');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function myMatches(){
        if (config('settings.referee'))
               return view('backend.program.program.myMatches');
        else
            return redirect()->back()->withFlashDanger('Δεν έχετε δικαιώμα να εκτυπώσετε Φύλλα Αγώνα');
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
     * @param  \App\program  $program
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $program= program::selectRaw('programs.met_id as met_id, programs.player_id as deltio, CONCAT(players.Surname," ",players.Name) as name, teams_from.onoma_web as team_from, teams_to.onoma_web as team_to')
                ->join('players', 'players.player_id','=', 'programs.player_id')
                ->join('teams as teams_from','teams_from.team_id','=','programs.team_id_from')
                ->join('teams as teams_to','teams_to.team_id','=','programs.team_id_to')
                ->join('teamspergroup','teamspergroup.team','=','teams_to.team_id')
                ->join('group1', 'teamspergroup.group','=','group1.aa_group')
                ->join('season', 'group1.aa_period','=', 'season.season_id')
                ->where('season.season_id','=',session('season'))
                ->where('group1.regular_season','=',1)
                ->whereRaw('programs.date Between season.enarxi and season.lixi')
                ->orderby('programs.date', 'desc')
                ->get();
        return Datatables::of($program)
        ->addColumn('actions',function($program){
                //return $herbs->getEditButtonAttribute($herbs->id);
                return view('backend.program.partials.actions',['id'=>$program->met_id, 'flexible'=>'activate', 'page'=>'program']);
        })
        ->rawColumns(['actions'])
        ->make(true);
        
    } 

 //Πρόγραμμα με φύλλα αγώνα ανά κατηγορία και αγωνιστική 
    public function programMD(){

        $category= request('category');
        $md_from= request('md_from');
        $md_to= request('md_to');
        if (is_null($md_to)){
            $md_to=$md_from;
        }elseif(is_null($md_from)){
            $md_from=$md_to;
        }
        session()->put('category', $category);
        session()->put('md_from', $md_from);
        session()->put('md_to', $md_to);
        $matches= matches::selectRaw('matches.aa_game as id, matches.*, team1.onoma_web as ghp, team2.onoma_web as fil, fields.eps_name as arena, fields.aa_gipedou as arena_id, group1.title as category,  group1.category as cat, group1.locked as groupLocked,  champs.flexible as flexible, matches.score_team_1 as score1, matches.score_team_2 as score2, matches.publ as prog_publ, matches.published as ref_publ, matches.publ_doc as doc_publ, matches.publ_ref_obs as ref_obs_publ, "-" as dash')
                ->join('teams as team1', 'team1.team_id','=', 'matches.team1')
                ->join('teams as team2', 'team2.team_id','=', 'matches.team2')
                ->join('group1', 'group1.aa_group' ,'=','matches.group1')
                ->join('champs', 'group1.category' ,'=','champs.champ_id')
                ->join('fields', 'fields.aa_gipedou','=','matches.court')
                ->where('matches.group1','=', $category)
                ->whereBetween('matches.match_day',array($md_from, $md_to))
                ->orderby('matches.match_day', 'asc')
                ->get();
        return Datatables::of($matches)
        ->addColumn('actions',function($matches){
                $flexible=($matches->flexible==1)?true:false;
                $match_stats=(strlen($matches->score1)>0)?true:false;
                $edit=($matches->stats==1)?true:false;
                $locked=($matches->groupLocked==1)?true:false;
                $postponed=($matches->postponed==1)?true:false;
                $live=($matches->live==1)?true:false;
                return view('backend.program.partials.actions',['id'=>$matches->id, 'flexible'=>$flexible, 'category'=>$matches->cat, 'page'=>'flexible', 'match_stats'=>$match_stats, 'postponed'=>$postponed, 'edit'=>$edit, 'locked'=>$locked, 'live'=>$live]);
        })
        ->addColumn('match', function($matches){
                return $matches->ghp.' - '.$matches->fil;
            })
        ->addColumn('date', function($matches){
            if ($matches->date_time==config('default.datetime')){
                $date='';
                $dataDate=Carbon::now()->format('d/m/Y H:i');
            }else{
                $date=Carbon::parse($matches->date_time)->format('d/m/Y H:i');
                $dataDate=Carbon::parse($matches->date_time)->format('d/m/Y H:i');
            }
            $readonly=(strlen($matches->score1)>0 || $matches->groupLocked==1)?true:false;

            return view('backend.program.partials.date',['date'=>$date, 'dataDate'=>$dataDate, 'match'=>$matches->id, 'readonly'=>$readonly]);
            })
        ->addColumn('arena', function($matches){
             $readonly=(strlen($matches->score1)>0 || $matches->groupLocked==1)?true:false;
            return view('backend.program.partials.court',['court'=>$matches->arena, 'court_id'=>$matches->arena_id, 'match'=>$matches->id, 'readonly'=>$readonly ]);
            })
        ->addColumn('score1', function($matches){
            $readonly=($matches->groupLocked==1 || strlen($matches->score1)>0)?true:false;
            return view('backend.program.partials.score1',['score1'=>$matches->score1, 'match'=>$matches->id, 'readonly'=>$readonly ]);
            })
        ->addColumn('score2', function($matches){
            $readonly=($matches->groupLocked==1 || strlen($matches->score2)>0)?true:false;
            return view('backend.program.partials.score2',['score2'=>$matches->score2, 'match'=>$matches->id, 'readonly'=>$readonly ]);
            })
        ->addColumn('prog_publ', function($matches){
             $readonly=($matches->groupLocked==1)?true:false;
            return view('backend.program.partials.prog_publ',['prog_publ'=>$matches->prog_publ, 'match'=>$matches->id , 'readonly'=>$readonly ]);
            })
        ->addColumn('live', function($matches){
             $readonly=($matches->groupLocked==1)?true:false;
            return view('backend.program.partials.live',['live'=>$matches->live, 'match'=>$matches->id , 'readonly'=>$readonly ]);
            })
        ->addColumn('check', function($matches){
                return '<input type="checkbox" class="form-check-input match" name="selected_matches[]" value="'.$matches->id.'" checked="checked">';   
            }) 
        ->rawColumns(['actions',  'ref_publ', 'prog_publ','check', 'date', 'arena', 'score1', 'score2', 'live'])
        ->make(true);
    }


//Πρόγραμμα με φύλλα αγώνα ανά κατηγορία και αγωνιστική 
    public function programDate(){

        $date_from= request('date_from');
        $date_to= request('date_to');
        if (is_null($date_to)){
            $date_to=$date_from;
        }elseif(is_null($date_from)){
            $date_from=$date_to;
        }elseif(is_null($date_from) && is_null($date_to)){
            $date_from= Carbon::now();
            $date_to= Carbon::now();
        }else{
            $format = 'd/m/Y';
            $date_from = Carbon::createFromFormat($format, $date_from);
            $date_to = Carbon::createFromFormat($format, $date_to); 
        }

        session()->put('date_from', $date_from);
        session()->put('date_to', $date_to);
        
        $date_from= Carbon::parse($date_from)->format('Y/m/d 00:00');
        $date_to= Carbon::parse($date_to)->format('Y/m/d 23:59');
        $matches= matches::selectRaw('matches.aa_game as id, matches.*, team1.onoma_web as ghp, team2.onoma_web as fil, fields.eps_name as arena, fields.aa_gipedou as arena_id, group1.title as category, group1.category as cat, group1.locked as groupLocked, matches.score_team_1 as score1, champs.flexible as flexible, matches.score_team_2 as score2, matches.publ as prog_publ, matches.published as ref_publ, matches.publ_doc as doc_publ, matches.publ_ref_obs as ref_obs_publ, "-" as dash')
                ->join('teams as team1', 'team1.team_id','=', 'matches.team1')
                ->join('teams as team2', 'team2.team_id','=', 'matches.team2')
                ->join('group1', 'group1.aa_group' ,'=','matches.group1')
                ->join('champs', 'group1.category' ,'=','champs.champ_id')
                ->join('fields', 'fields.aa_gipedou','=','matches.court')
                ->where('matches.date_time','<>',config('default.datetime'))
                ->whereBetween('matches.date_time',array($date_from, $date_to))
                ->orderby('matches.group1', 'asc')
                ->orderby('matches.date_time', 'asc')
                ->get();
        return Datatables::of($matches)
        ->addColumn('actions',function($matches){
                $flexible=($matches->flexible==1)?true:false;
                $match_stats=(strlen($matches->score1)>0)?true:false;
                $edit=($matches->stats==1)?true:false;
                $locked=($matches->groupLocked==1)?true:false;
                $postponed=($matches->postponed==1)?true:false;
                $live=($matches->live==1)?true:false;
                return view('backend.program.partials.actions',['id'=>$matches->id, 'flexible'=>$flexible, 'category'=>$matches->cat, 'page'=>'flexible', 'match_stats'=>$match_stats, 'postponed'=>$postponed, 'edit'=>$edit, 'locked'=>$locked, 'live'=>$live]);
        })
        ->addColumn('match', function($matches){
                return $matches->ghp.' - '.$matches->fil;
            })
        ->addColumn('date', function($matches){
            if ($matches->date_time==config('default.datetime')){
                $date='';
                $dataDate=Carbon::now()->format('d/m/Y H:i');
            }else{
                $date=Carbon::parse($matches->date_time)->format('d/m/Y H:i');
                $dataDate=Carbon::parse($matches->date_time)->format('d/m/Y H:i');
            }
            $readonly=(strlen($matches->score1)>0 || $matches->groupLocked==1)?true:false;

            return view('backend.program.partials.date',['date'=>$date, 'dataDate'=>$dataDate, 'match'=>$matches->id, 'readonly'=>$readonly]);
            })
        ->addColumn('arena', function($matches){
             $readonly=(strlen($matches->score1)>0 || $matches->groupLocked==1)?true:false;
            return view('backend.program.partials.court',['court'=>$matches->arena, 'court_id'=>$matches->arena_id, 'match'=>$matches->id, 'readonly'=>$readonly ]);
            })
        ->addColumn('score1', function($matches){
            $readonly=($matches->groupLocked==1 || strlen($matches->score1)>0)?true:false;
            return view('backend.program.partials.score1',['score1'=>$matches->score1, 'match'=>$matches->id, 'readonly'=>$readonly ]);
            })
        ->addColumn('score2', function($matches){
            $readonly=($matches->groupLocked==1 || strlen($matches->score1)>0)?true:false;
            return view('backend.program.partials.score2',['score2'=>$matches->score2, 'match'=>$matches->id, 'readonly'=>$readonly ]);
            })
        ->addColumn('prog_publ', function($matches){
             $readonly=($matches->groupLocked==1)?true:false;
            return view('backend.program.partials.prog_publ',['prog_publ'=>$matches->prog_publ, 'match'=>$matches->id , 'readonly'=>$readonly ]);
            })
        ->addColumn('live', function($matches){
             $readonly=($matches->groupLocked==1)?true:false;
            return view('backend.program.partials.live',['live'=>$matches->live, 'match'=>$matches->id , 'readonly'=>$readonly ]);
            })
        ->addColumn('check', function($matches){
                return '<input type="checkbox" class="form-check-input match" name="selected_matches[]" value="'.$matches->id.'" checked="checked">';   
            }) 
        ->rawColumns(['actions',  'ref_publ', 'prog_publ','check', 'date', 'arena', 'score1', 'score2', 'live'])
        ->make(true);
    }


    /**
     * Check Court indegrity.
     *
     * @param  \App\referees  $referees
     * @return \Illuminate\Http\Response
     */


     public function courtCheck()
    {
        $date_from= request('date_from');
        $date_to= request('date_to');
        if (is_null($date_to)){
            $date_to=$date_from;
        }elseif(is_null($date_from)){
            $date_from=$date_to;
        }elseif(is_null($date_from) && is_null($date_to)){
            $date_from= Carbon::now();
            $date_to= Carbon::now();
        }else{
            $format = 'd/m/Y';
            $date_from = Carbon::createFromFormat('d/m/Y', $date_from);
            $date_to = Carbon::createFromFormat('d/m/Y', $date_to); 
            
        }

            session()->put('date_from', $date_from);
            session()->put('date_to', $date_to);
        $date_from= Carbon::parse($date_from)->format('Y/m/d 00:00');
        $date_to= Carbon::parse($date_to)->format('Y/m/d 23:59');
       
        $matches=DB::select("SELECT matches.aa_game as id, matches.match_day, matches.date_time, matches.group1, matches.score_team_1 as score1,group1.locked as groupLocked,
                             matches.score_team_2 as score2, group1.omilos, group1.title  AS category, teams1.onoma_web AS ghp, teams2.onoma_web AS fil,
                             matches.publ as pub, matches.notified as notif, matches.court as f_id, matches.postponed as pp, fields.eps_name as arena, fields.aa_gipedou as arena_id, matches.publ as prog_publ, matches.published as ref_publ, '-' as dash
                                     FROM matches
                                     inner join group1 on group1.aa_group = matches.group1
                                     inner join teams AS teams1 on teams1.team_id = matches.team1
                                     inner join teams AS teams2 on teams2.team_id = matches.team2
                                     inner join fields on  fields.aa_gipedou = matches.court
                                     inner join (Select * from matches where matches.date_time>= '$date_from' and matches.date_time<= '$date_to')T2 on (T2.court=matches.court and T2.aa_game<>matches.aa_game and matches.date_time<= DATE_ADD(T2.date_time, INTERVAL 1 HOUR) and matches.date_time>= DATE_SUB(T2.date_time, INTERVAL 1 HOUR) )
                                     WHERE  matches.date_time>= '$date_from' and matches.date_time<= '$date_to'
                                     ORDER BY   matches.date_time asc, matches.group1 asc");
        return Datatables::of($matches)
        
        ->addColumn('match', function($matches){
                return $matches->ghp.' - '.$matches->fil;
            })
        ->addColumn('date', function($matches){
            if ($matches->date_time==config('default.datetime')){
                $date='';
                $dataDate=Carbon::now()->format('d/m/Y H:i');
            }else{
                $date=Carbon::parse($matches->date_time)->format('d/m/Y H:i');
                $dataDate=Carbon::parse($matches->date_time)->format('d/m/Y H:i');
            }
            $readonly=(strlen($matches->score1)>0)?true:false;
            return view('backend.program.partials.date',['date'=>$date, 'dataDate'=>$dataDate, 'match'=>$matches->id, 'readonly'=>$readonly]);
            })
        ->addColumn('arena', function($matches){
             $readonly=(strlen($matches->score1)>0)?true:false;
            return view('backend.program.partials.court',['court'=>$matches->arena, 'court_id'=>$matches->arena_id, 'match'=>$matches->id, 'readonly'=>$readonly ]);
            })
        ->addColumn('score1', function($matches){
            $readonly=($matches->groupLocked==1 || strlen($matches->score1)>0)?true:false;
            return view('backend.program.partials.score1',['score1'=>$matches->score1, 'match'=>$matches->id, 'readonly'=>$readonly ]);
            })
        ->addColumn('score2', function($matches){
            $readonly=($matches->groupLocked==1 || strlen($matches->score2)>0)?true:false;
            return view('backend.program.partials.score2',['score2'=>$matches->score2, 'match'=>$matches->id, 'readonly'=>$readonly ]);
            })
        ->addColumn('prog_publ', function($matches){
             $readonly=($matches->groupLocked==1)?true:false;
            return view('backend.program.partials.prog_publ',['prog_publ'=>$matches->prog_publ, 'match'=>$matches->id , 'readonly'=>$readonly ]);
            })
        ->addColumn('check', function($matches){
                return '<input type="checkbox" class="form-check-input match" name="selected_matches[]" value="'.$matches->id.'" checked="checked">';   
            }) 
        ->rawColumns(['actions',  'ref_publ', 'prog_publ','check', 'date', 'arena', 'score1', 'score2'])
        ->make(true);
    }


     public function matchesWithOutScore(){

        
        $matches= matches::selectRaw('matches.aa_game as id, matches.*, team1.onoma_web as ghp, team2.onoma_web as fil, fields.eps_name as arena, fields.aa_gipedou as arena_id, group1.title as category, group1.category as cat, matches.score_team_1 as score1, matches.score_team_2 as score2, matches.publ as prog_publ, matches.published as ref_publ, matches.publ_doc as doc_publ, matches.publ_ref_obs as ref_obs_publ, "-" as dash')
                ->join('teams as team1', 'team1.team_id','=', 'matches.team1')
                ->join('teams as team2', 'team2.team_id','=', 'matches.team2')
                ->join('group1', 'group1.aa_group' ,'=','matches.group1')
                ->join('fields', 'fields.aa_gipedou','=','matches.court')
                ->where('group1.aa_period', '=', season::getRunning()->season_id)
                ->where('matches.date_time','<>','0000-00-00 00:00:00')
                ->where('matches.date_time','<>',config('default.datetime'))
                ->where('matches.date_time','<',Carbon::parse(Carbon::now()->addHours(5))->format('Y/m/d H:s:i'))
                ->whereNull('score_team_1')
                ->whereNull('score_team_2')
                ->orderby('matches.group1', 'asc')
                ->orderby('matches.match_day', 'asc')
                ->get();
        return Datatables::of($matches)
        ->addColumn('actions',function($matches){
                //return $herbs->getEditButtonAttribute($herbs->id);
                return view('backend.program.partials.actions',['id'=>$matches->id, 'category'=>$matches->cat, 'page'=>'matches']);
        })
        ->addColumn('match', function($matches){
                return $matches->ghp.' - '.$matches->fil;
            })
        ->addColumn('date_time', function($matches){
            if ($matches->date_time==config('default.datetime')){
                $date='';
                $dataDate=Carbon::now()->format('d/m/Y H:i');
            }else{
                $date=Carbon::parse($matches->date_time)->format('d/m/Y H:i');
                $dataDate=Carbon::parse($matches->date_time)->format('d/m/Y H:i');
            }
            return $date;
            })
        ->rawColumns(['actions'])
        ->make(true);
    }
    /* Display Score Update Modal*/
    public function score($id){
        $matches=matches::selectRaw('matches.aa_game as id, matches.*, team1.onoma_web as ghp, team2.onoma_web as fil')
                        ->join('teams as team1', 'team1.team_id','=', 'matches.team1')
                        ->join('teams as team2', 'team2.team_id','=', 'matches.team2')
                        ->where('aa_game','=',$id)
                        ->get();

        return view('backend.program.program.scoreModal', compact('matches'));
    }

    public function postpone($id)
    {
         $matches= matches::findOrFail($id);               
         $matches->postponed= 1;
         $matches->save();

         return redirect()->back()->withFlashSuccess('Επιτυχής Ενημέρωση');     
    }

    public function depostpone($id)
    {
        $matches= matches::findOrFail($id);               
         $matches->postponed= 0;
         $matches->save();

         return redirect()->back()->withFlashSuccess('Επιτυχής Ενημέρωση');     
    }

/* Updates Score */
    public function scoreUpdate($id){
         $this->validate(request(), [
                'score_team_1'=> 'numeric|nullable',
                'score_team_2'=> 'numeric|nullable',
            ]);
        $score1=request('score_team_1');
        $score2=request('score_team_2');
        $matches=matches::findOrFail($id);
        $matches->score_team_1=request('score_team_1');
        $matches->score_team_2=request('score_team_2');
        $qt1 = teamsPerGroup::where('team', $matches->team1)->where('group', $matches->group1)->first();
        $qt2 = teamsPerGroup::where('team', $matches->team2)->where('group', $matches->group1)->first();
        if(!(is_null($score1)) || !(is_null($score2)) && $matches->poines == 0 ){
            if ($score1>$score2){
               
                $qt1->points += 3;
                $qt1->match_home += 1;
                $qt1->wins_home += 1;
                $qt1->goalHomePlus += $score1;
                $qt1->goalHomeMinus += $score2;
                $qt1->save();

                $qt2->match_away += 1;
                $qt2->defeat_away += 1;
                $qt2->goalAwayPlus += $score2;
                $qt2->goalAwayMinus += $score1;
                $qt2->save();
                
                $matches->points1=3;
                $matches->points2=0;

            }elseif ($score1<$score2){
               
                $qt1->match_home += 1;
                $qt1->defeat_home += 1;
                $qt1->goalHomePlus += $score1;
                $qt1->goalHomeMinus += $score2;
                $qt1->save();

                $qt2->points += 3;
                $qt2->match_away += 1;
                $qt2->wins_away += 1;
                $qt2->goalAwayPlus += $score2;
                $qt2->goalAwayMinus += $score1;
                $qt2->save();
               
                $matches->points1=0;
                $matches->points2=3;
            }else{
               
                $qt2->points += 1;
                $qt1->match_home += 1;
                $qt1->draws_home += 1;
                $qt1->goalHomePlus += $score1;
                $qt1->goalHomeMinus += $score2;
                $qt1->save();

                $qt2->points += 1;
                $qt2->match_away += 1;
                $qt2->draws_away += 1;
                $qt2->goalAwayPlus += $score2;
                $qt2->goalAwayMinus += $score1;
                $qt2->save();
               
                $matches->points1=1;
                $matches->points2=1;
            }
        }
        /*Penalties Update Remain*/
        if($matches->poines==0){
            $pPl=penaltyPlayer::join('players', 'penalties_players.player_id', '=', 'players.player_id')
                                ->where('penalties_players.remain','>', 0)
                                ->where('penalties_players.kind_of_days','=','1')
                                ->where(function($query) use ($matches){
                                            $query->where('players.teams_team_id','=', $matches->team1)
                                                  ->orWhere('players.teams_team_id','=', $matches->team2);
                                            })
                                ->decrement('remain');
             $pOf=penaltyOfficial::where('penalties_officials.remain','>', 0)
                                ->where('penalties_officials.kind_of_days','=','1')
                                ->where(function($query) use ($matches){
                                            $query->where('team_id','=', $matches->team1)
                                                  ->orWhere('team_id','=', $matches->team2);
                                            })
                                ->decrement('remain');     
            $pTe=penaltyTeam::where('penalties_teams.remain','>', 0)
                                ->where(function($query) use ($matches){
                                            $query->where('team_id','=', $matches->team1)
                                                  ->orWhere('team_id','=', $matches->team2);
                                            })
                                ->decrement('remain');     
            $matches->poines=1;
           
        }
        $matches->save(); 
        return redirect()->back()->withFlashSuccess('Επιτυχής Ενημέρωση');
    }
    /* Display Change Match Team Modal*/
    public function changeTeams($id){
        $matches=matches::selectRaw('matches.aa_game as id, matches.*')
                        ->where('aa_game','=',$id)
                        ->get();

        return view('backend.program.program.changeTeamsModal', compact('matches'));
    }

    /* Display Change Match Team Modal*/
    public function insertLink($id){
        $matches=matches::selectRaw('matches.aa_game as id, matches.*')
                        ->where('aa_game','=',$id)
                        ->get();

        return view('backend.program.program.insertLinkModal', compact('matches'));
    }

     public function teamsUpdate($id){
         $this->validate(request(), [
                'team1'=> 'required',
                'team2'=> 'required',
            ]);
        $matches=matches::findOrFail($id);
        $matches->team1=request('team1');
        $matches->team2=request('team2');
        $matches->save();  

        return redirect()->back()->withFlashSuccess('Επιτυχής Ενημέρωση');        
    }
    public function linkUpdate($id){
         $this->validate(request(), [
                'link'=> 'required',
            ]);
        $matches=matches::findOrFail($id);
        $matches->link=request('link');
        $matches->save();  

        return redirect()->back()->withFlashSuccess('Επιτυχής Ενημέρωση');        
    }
    /**
     * Saves the program for the selected matches.
     *
     * @param  \App\program  $program
     * @return \Illuminate\Http\Response
     */
    public function saveSelected()
    {
        
        $matches = Input::get('selected_matches');
        if (sizeof($matches)>0){
        foreach ($matches as $match){
            $datetime=request('datetime-'.$match);
            $court=request('court_id-'.$match);
            $score1=request('score1-'.$match);
            $score2=request('score2-'.$match);
            if( Request::input('published-'.$match) ) {
                    $publ=1;
                } else {
                    $publ=0;
                }
            if( Request::input('live-'.$match) ) {
                    $live=1;
                } else {
                    $live=0;
                }
            $format = 'd/m/Y H:i';
            if(empty($datetime)){
                $datetime=config('default.datetime');
            }else{
                $datetime = Carbon::createFromFormat($format, $datetime); 
            }
             
             $cur_match= matches::findOrFail($match);
             $cur_match->date_time= Carbon::parse($datetime)->format('Y/m/d H:i');
             $cur_match->court=$court;
             $cur_match->score_team_1=$score1;
             $cur_match->score_team_2=$score2;
             if(!(is_null($score1)) || !(is_null($score2))){
                if($cur_match->poines==0){
                     $tPG1=teamsPerGroup::where('team','=',$cur_match->team1)->where('group','=',$cur_match->group1)->first();
                     $tPG2=teamsPerGroup::where('team','=',$cur_match->team2)->where('group','=',$cur_match->group1)->first();
                 if ($score1>$score2){
                    $cur_match->points1=3;
                    $cur_match->points2=0;
                        try{
                            $tPG1->increment('points', 3);
                            $tPG1->increment('match_home', 1);
                            $tPG1->increment('wins_home', 1);
                            $tPG2->increment('defeat_away', 1);
                            $tPG2->increment('match_away', 1);
                            }catch (\Exception $e) {
                               return $e->getMessage();
                            }
                    
                }elseif ($score1<$score2){
                    $cur_match->points1=0;
                    $cur_match->points2=3;
                        try{
                            $tPG1->increment('match_home', 1);
                            $tPG1->increment('defeat_home', 1);
                            $tPG2->increment('points', 3);
                            $tPG2->increment('wins_away', 1);
                            $tPG2->increment('match_away', 1);
                            }catch (\Exception $e) {
                               return $e->getMessage();
                            }
                    
                }else{
                    $cur_match->points1=1;
                    $cur_match->points2=1;
                        try{
                            $tPG1->increment('points', 1);
                            $tPG1->increment('match_home', 1);
                            $tPG1->increment('draws_home', 1);
                            $tPG2->increment('points', 1);
                            $tPG2->increment('match_away', 1);
                            $tPG2->increment('draws_away', 1);
                            }catch (\Exception $e) {
                               return $e->getMessage();
                            }
                    
                }
                $tPG1->increment('goalHomePlus', $score1);
                $tPG1->increment('goalHomeMinus', $score2);
                $tPG2->increment('goalAwayPlus', $score2);
                $tPG2->increment('goalAwayMinus', $score1);
                $pPl=penaltyPlayer::join('players', 'penalties_players.player_id', '=', 'players.player_id')
                                            ->where('penalties_players.remain','>', 0)
                                            ->where('penalties_players.kind_of_days','=','1')
                                            ->where(function($query) use ($cur_match){
                                                        $query->where('players.teams_team_id','=', $cur_match->team1)
                                                              ->orWhere('players.teams_team_id','=', $cur_match->team2);
                                                        })
                                            ->decrement('remain');
                $pOf=penaltyOfficial::where('penalties_officials.remain','>', 0)
                                            ->where('penalties_officials.kind_of_days','=','1')
                                            ->where(function($query) use ($cur_match){
                                                        $query->where('team_id','=', $cur_match->team1)
                                                              ->orWhere('team_id','=', $cur_match->team2);
                                                        })
                                            ->decrement('remain');     
                $pTe=penaltyTeam::where('penalties_teams.remain','>', 0)
                                            ->where(function($query) use ($cur_match){
                                                        $query->where('team_id','=', $cur_match->team1)
                                                              ->orWhere('team_id','=', $cur_match->team2);
                                                        })
                                            ->decrement('remain');     
                $cur_match->poines=1;
            }
                
            }

            
             $cur_match->live=$live;
             $cur_match->publ=$publ;
             $cur_match->save();
        }

       return redirect()->back()->withFlashSuccess('Επιτυχής Αποθήκευση');
   }else{
        return redirect()->back()->withFlashDanger('Δεν έχετε επιλέξει κάποια αναμέτρηση');
   }
    }

    public function resetMatch($id){
        $cur_match= matches::findOrFail($id);
        $cur_match->points1=0;
        $cur_match->points2=0;
        $tPG1=teamsPerGroup::where('team','=',$cur_match->team1)->where('group','=',$cur_match->group1)->first();
        $tPG2=teamsPerGroup::where('team','=',$cur_match->team2)->where('group','=',$cur_match->group1)->first();
         if ($cur_match->score_team_1>$cur_match->score_team_2){
            $tPG1->decrement('points', 3);
            $tPG1->decrement('match_home', 1);
            $tPG1->decrement('wins_home', 1);
            $tPG2->decrement('defeat_away', 1);
            $tPG2->decrement('match_away', 1);
         }elseif($cur_match->score_team_1<$cur_match->score_team_2){
            $tPG1->decrement('match_home', 1);
            $tPG1->decrement('defeat_home', 1);
            $tPG2->decrement('points', 3);
            $tPG2->decrement('wins_away', 1);
            $tPG2->decrement('match_away', 1);
         }else{
            $tPG1->decrement('points', 1);
            $tPG1->decrement('match_home', 1);
            $tPG1->decrement('draws_home', 1);
            $tPG2->decrement('points', 1);
            $tPG2->decrement('match_away', 1);
            $tPG2->decrement('draws_away', 1);
         }
        $tPG1->decrement('goalHomePlus', $cur_match->score_team_1);
        $tPG1->decrement('goalHomeMinus', $cur_match->score_team_2);
        $tPG2->decrement('goalAwayPlus', $cur_match->score_team_2);
        $tPG2->decrement('goalAwayMinus', $cur_match->score_team_1);
        $cur_match->score_team_1='';
        $cur_match->score_team_2='';
        $pPl=penaltyPlayer::join('players', 'penalties_players.player_id', '=', 'players.player_id')
                                            ->where('penalties_players.remain','>', 0)
                                            ->where('penalties_players.kind_of_days','=','1')
                                            ->where(function($query) use ($cur_match){
                                                        $query->where('players.teams_team_id','=', $cur_match->team1)
                                                              ->orWhere('players.teams_team_id','=', $cur_match->team2);
                                                        })
                                            ->increment('remain');
        $pOf=penaltyOfficial::where('penalties_officials.remain','>', 0)
                                            ->where('penalties_officials.kind_of_days','=','1')
                                            ->where(function($query) use ($cur_match){
                                                        $query->where('team_id','=', $cur_match->team1)
                                                              ->orWhere('team_id','=', $cur_match->team2);
                                                        })
                                            ->increment('remain');     
        $pTe=penaltyTeam::where('penalties_teams.remain','>', 0)
                                            ->where(function($query) use ($cur_match){
                                                        $query->where('team_id','=', $cur_match->team1)
                                                              ->orWhere('team_id','=', $cur_match->team2);
                                                        })
                                            ->increment('remain');     
        $cur_match->poines=0;
        $cur_match->save();
            return redirect()->back()->withFlashSuccess('Η αναμέτρηση επαναφέρθηκε');
    }


    /* Πρόγραμμα αναμετρήσεων κάθε Παρατηρητή*/
    public function getMyObserverMatches(){
            $user=request('observer');
            $time=request('time');
            $symbol= ($time=='before')?'<':'>=';
            $observers= observer::selectRaw('wa_id as id')
                                ->join('users', 'users.mobile','=','paratirites.waTel')
                                ->where('users.id','=',$user)
                                ->get();
            foreach($observers as $observer)
            $id= $observer->id;
            $matches= matches::selectRaw('matches.aa_game as id, matches.*, DATE(matches.date_time) as hmer, team1.onoma_web as ghp, team2.onoma_web as fil, fields.eps_name as arena, group1.title as category, group1.category as cat, group1.locked as groupLocked, matches.score_team_1 as score1, matches.score_team_2 as score2')
                ->join('teams as team1', 'team1.team_id','=', 'matches.team1')
                ->join('teams as team2', 'team2.team_id','=', 'matches.team2')
                ->join('group1', 'group1.aa_group' ,'=','matches.group1')
                ->join('season', 'season.season_id','=', 'group1.aa_period')
                ->join('fields', 'fields.aa_gipedou','=','matches.court')
                ->where('season.season_id','=',session('season'))
                ->where('matches.published','=', '0')
                ->where('matches.date_time','<>',config('default.datetime'))
                ->where('matches.date_time',$symbol,Carbon::now()->format('Y/m/d'))
                ->where('matches.paratiritis','=', $id)
                ->orderby('matches.date_time', 'desc')->get();
        return Datatables::of($matches)
        ->addColumn('actions',function($matches){
                $readonly=(strlen($matches->score1)>0 || $matches->groupLocked==1)?true:false;
                $edit=($matches->stats==1)?true:false;
                $locked=($matches->groupLocked==1)?true:false;
                $postponed=($matches->postponed==1)?true:false;
                $grades=($matches->ref_grades>0)?true:false;
                $insertScore=(Carbon::parse($matches->date_time)->addMinutes(180)->greaterThan(Carbon::now()))?true:false;
                $canStart=(Carbon::parse($matches->date_time)->subMinutes(10)->lessThan(Carbon::now()))?true:false;
                return view('backend.program.partials.observer.actions',['id'=>$matches->id, 'category'=>$matches->cat, 'readonly'=>$readonly, 'edit'=>$edit, 'locked'=>$locked, 'postponed'=>$postponed, 'grades'=>$grades, 'insertScore'=>$insertScore, 'canStart'=>$canStart, 'now'=>Carbon::now()->format('Y/m/d H:i:s'), 'sTime'=>Carbon::parse($matches->date_time)->subMinutes(10)->format('Y/m/d H:i:s'), 'lTime'=>Carbon::parse($matches->date_time)->addMinutes(180)->format('Y/m/d H:i:s')]);
        })
        ->addColumn('match', function($matches){
                return $matches->ghp.' - '.$matches->fil;
            })
        ->addColumn('date', function($matches){
                return Carbon::parse($matches->date_time)->format('d/m/Y H:i');
            })
        ->rawColumns(['actions'])
        ->make(true);
    }

    /* Πρόγραμμα αναμετρήσεων κάθε Διαιτητή*/
    public function getMyMatches(){
            $user=request('referee');
            $time=request('time');
            $symbol= ($time=='before')?'<':'>=';
            $referees= Referees::selectRaw('refaa as id')
                                ->join('users', 'users.mobile','=','referees.tel')
                                ->where('users.id','=',$user)
                                ->get();
            foreach($referees as $referee)
            $id= $referee->id;
            $matches= matches::selectRaw('matches.aa_game as id, matches.*, team1.onoma_web as ghp, team2.onoma_web as fil, fields.eps_name as arena, group1.title as category, group1.category as cat, group1.locked as groupLocked, matches.score_team_1 as score1, matches.score_team_2 as score2')
                ->join('teams as team1', 'team1.team_id','=', 'matches.team1')
                ->join('teams as team2', 'team2.team_id','=', 'matches.team2')
                ->join('group1', 'group1.aa_group' ,'=','matches.group1')
                ->join('season', 'season.season_id','=', 'group1.aa_period')
                ->join('fields', 'fields.aa_gipedou','=','matches.court')
                ->where('season.season_id','=',session('season'))
                ->where('matches.published','=', '0')
                ->where('matches.date_time','<>',config('default.datetime'))
                ->where(function($query) use ($id){
                    $query->where('matches.referee','=', $id)
                          ->orWhere('matches.helper1','=', $id)
                          ->orWhere('matches.helper2','=', $id);
                })
                ->orderby('matches.date_time', 'desc')->get();
        return Datatables::of($matches)
        ->addColumn('actions',function($matches) use ($id){
                $readonly=(strlen($matches->score1)>0 || $matches->groupLocked==1)?true:false;
                $edit=($matches->stats==1)?true:false;
                $locked=($matches->groupLocked==1)?true:false;
                $postponed=($matches->postponed==1)?true:false;
                $grades=($matches->ref_grades>0)?true:false;
                $insertScore=(Carbon::parse($matches->date_time)->addMinutes(90)->lessThan(Carbon::now()))?true:false;
                $accepted = RefereeNotification::whereMatchId($matches->id)->whereRefereeId($id)->first();
                return view('backend.program.partials.referee.actions',[
                    'id'=>$matches->id, 
                    'category'=>$matches->cat, 
                    'readonly'=>$readonly, 
                    'edit'=>$edit, 
                    'locked'=>$locked, 
                    'postponed'=>$postponed, 
                    'grades'=>$grades, 
                    'insertScore'=>$insertScore,
                    'accepted' => $accepted
                ]);
        })
        ->addColumn('match', function($matches){
                return $matches->ghp.' - '.$matches->fil;
            })
        ->addColumn('date', function($matches){
                return Carbon::parse($matches->date_time)->format('d/m/Y H:i');
            })
        ->rawColumns(['actions'])
        ->make(true);
    }
   

}
